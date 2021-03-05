<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 


class RestContactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     * @Route("/place/{id}/contacts", name="rest_contact_index")
     * @Method("GET")
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('AppBundle:Contact')->findAll();
        $response = new Response(json_encode($contacts), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

      /**
     * Finds and displays a contact entity.
     *
     * @Route("/place/contact/{id}", name="rest_contact_show", requirements={"id" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})

     * @Method("GET")
     */
    public function showAction(Contact $contact)
    {
        $response = new Response(json_encode($contact), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new contact entity.
     *
     * @Route("/place/{id}/contact", name="rest_contact_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request,$id)
    {
        $contact = new Contact();
         $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\ContactType', $contact);
        $place = $em->getRepository(Place::class)->findOneByUuid($id);
        if(empty($place)){
        	$response = new Response(json_encode(array("error" => "Place Not found")), Response::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        $contact->setPlace($place);
        $data=json_decode($request->getContent(),$responseAsArray=true);
        $content= $request->getContent();
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $response = new Response(json_encode(array("results" => "Operation Successful")), Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $response = new Response(json_encode(array("error" => "the form is invalid")), Response::HTTP_BAD_REQUEST );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        
    }

 

    /**
     * Displays a form to edit an existing contact entity.
     *
     * @Route("/place/contact/{id}", name="rest_contact_edit", requirements={"id" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Method({"PATCH"})
     */
    public function editAction(Request $request, Contact $contact)
    {   
        if($request->isMethod('patch')){
            $editForm = $this->createForm('AppBundle\Form\ContactType', $contact);
            $data=json_decode($request->getContent(),true);
            $editForm->submit($data);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $response = new Response(json_encode(array("result"=>"ressource patched successfully")), Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }
        else{
             $response = new Response(json_encode(array("error"=>"the form is invalid")), Response::HTTP_BAD_REQUEST);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
        }
    }

    /**
     * Deletes a contact entity.
     *
     * @Route("/place/contact/{id}", name="rest_contact_delete", requirements={"id" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Contact $contact)
    { 
        $em = $this->getDoctrine()->getManager();
        dump($em);
        $em->remove($contact);
        $em->flush();
        $response = new Response(null,Response::HTTP_NO_CONTENT);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
