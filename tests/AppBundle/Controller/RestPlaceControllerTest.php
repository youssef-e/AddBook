<?php
namespace tests\AppBundle\Controller;

use EveryCheck\TestApiRestBundle\Controller\JsonApiAsArrayTestCase;
use EveryCheck\TestApiRestBundle\Loader\ResourcesFileLoader;

class RestPlaceControllerTest extends JsonApiAsArrayTestCase
{

    /**
     * @dataProvider ApiCallProvider
     */
    public function testAPICall($data_test)
    {
        $this->env = json_decode(file_get_contents(__DIR__."/../DataFixtures/env.json"), true);
        $this->genericTestAPICall($data_test);
    }

    public static function ApiCallProvider()
    {
        return ResourcesFileLoader::testCaseProvider(__DIR__,'access');
    }

    public function setUp($fixtureFilename = null)
    {
        parent::setUp('LoadAccess');
    }

}