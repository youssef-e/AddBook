<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 

class RestContactController extends Controller
{

    use ControllerTraits;

    /**
     *
     * @Route("/places/{id}/contacts", name="contact_index",requirements={"id" = "\d+"}, methods={"GET"})
     */
    public function indexAction(int $id)
    {   
        $em = $this->getDoctrine()->getManager();

        $place = $em->getRepository(Place::class)->findOneBy(["random_id"=>$id]);

        if(empty($place)){
            return $this->NotFound();
        }
        $contacts = $em->getRepository(Contact::class)->findByPlace($place);
        return $this->Ok($contacts);
    }

    /**
     *
     * @Route("/places/{id}/contact", name="contact_new",requirements={"id" = "\d+"}, methods={"POST"})
     */
    public function newAction(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $place = $em->getRepository(Place::class)->findOneBy(["random_id"=>$id]);

        if(empty($place)){
            return $this->NotFound();
        }       

        $contact = new Contact();
        $contact->place = $place;

        $form = $this->createForm('AppBundle\Form\ContactType', $contact);
        $data=json_decode($request->getContent(),$jsonAsArray = true);
        if(empty($data) ){
            $err =json_last_error_msg();
            if(!empty($err))
            {
                return $this->Error(["error"=>"Json : ".$err]);
            }
        }

        $form->submit($data);
        if (!$form->isValid()) {
            return $this->FormError($form);
        }

        $em->persist($contact);
        $em->flush();

        return $this->Created($contact);
    }


    /**
     *
     * @Route("/places/contacts/{id}", name="contact_show",requirements={"id" = "\d+"}, methods={"GET"})
     */
    public function showAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $contact = $em->getRepository(Contact::class)->findOneBy(["random_id"=>$id]);
        if(empty($contact)){
            return $this->NotFound();
        }
        
        return $this->Ok($contact);
    }

    /**
     *
     * @Route("/places/contacts/{id}", name="contact_edit",requirements={"id" = "\d+"}, methods={"PATCH"})
     */
    public function editAction(int $id, Request $request)
    {

        $contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findOneBy(["random_id"=>$id]);
        if(empty($contact)){
            return $this->NotFound();
        }

        $data=json_decode($request->getContent(),true);
        if(empty($data) ){
            $err =json_last_error_msg();
            if(!empty($err))
            {
                return $this->Error(["error"=>"Json : ".$err]);
            }
        }

        $editForm = $this->createForm('AppBundle\Form\ContactType', $contact);
        $editForm->submit($data);
        if (!$editForm->isValid()) {
            return $this->FormError($editForm);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();
        return $this->Ok($contact);
    }

    /**
     *
     * @Route("places/contacts/{id}", name="contact_delete",requirements={"id" = "\d+"}, methods={"DELETE"})
     */ 
     
    public function deleteAction(int $id, Request $request)
    {
        $contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findOneBy(["random_id"=>$id]);
        if(empty($contact)){
            return $this->Deleted();
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush(); 
         
        return $this->Deleted();


    }

}
