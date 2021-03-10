<?php  

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__."/../../../vendor/autoload.php";

use AppBundle\Entity\Place;
use AppBundle\Entity\Contact;
use GuzzleHttp\Client;

class Api{

    public function __construct($url,$debug)
    {
        $this->debug    = $debug;

        $this->guzzleClient = new Client([
            "base_uri" => $url,
            "timeout" => 180
        ]);
    }

    public function post(string $url,array $data) : stdClass
    {
        $response = $this->guzzleClient->request("POST", $url, $this->getOption($data));
        if($response->getStatusCode() !== 201)
        {
            $this->handleError($response);
        }
        return json_decode($response->getBody());

    }

    public function handleError($response)
    {
        if($response->hasHeader("X-Debug-Token-Link"))
        {
            throw new \Exception("Error happened. See more at " . $response->getHeader("X-Debug-Token-Link")[0]);
        }
        throw new \Exception("Error happened : " . $response->getStatusCode() . "\n Enable debug to see more.");
    }

    private function getOption($body)
    {
        return [
            "body" => json_encode($body),
            "debug" => $this->debug?fopen($this->debug,'w'):false,
            "headers" => ['Content-Type' => 'application/json' ],           
        ];
    }

    public function postPlace(array $place)
    {
        return $this->post("/place",$place);
    }

    public function postContact(int $id,array $contact)
    {
        return $this->post("/places/".$id."/contact",$contact);
    }

}

class LoadPlace
{
	public function execute($param)
    {
        $this->logCount = 1;

        $this->api = new Api($param['url'],$param['debug']);

        $demo = $this->createPlace();

        copy(__DIR__."/../../../var/data.sqlite", __DIR__."/../../../var/data/db_test/LoadPlace.sqlite");
        file_put_contents(__DIR__."/env.json", json_encode($this->env, JSON_PRETTY_PRINT));
    }

    private function store($object, $prefix)
    {
        $this->env[$prefix.$this->logCount] = $object;
        $this->logCount++;
    }

    private function createPlace()
    {
        $place1 = $this->api->postPlace([
            'name'=>'evck',
            'address'=>'11 rue erard',
            'comment'=>'best place to work',
        ]);

        $this->store($place1->id, "place_id_");

        $contact = $this->api->postContact($place1->id,[
            'firstname'=>'Leo',
            'lastname'=>'sok',
            'title'=>'project manager junior',
            'phone'=>'07777777777'
        ]);

        $this->store($contact->id, "contact_id_");
    }
}

try
{
	if(count($argv) < 3)
	{
		throw new \Exception("Usage : \n command url [debug]");
	}
	$arguments = [
		"url"    => $argv[1],
		"debug"  => $argv[2],
	];

    if ($arguments["debug"] == "false")
    {
        $arguments["debug"]=false;   
    }

	$test = new LoadPlace();
	$test->execute($arguments);
}
catch(\Exception $e)
{
	echo $e->getMessage();
	echo "\n";
}

echo "success\n";