<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 

class RestPlaceController extends Controller
{
    use ControllerTraits;

    /**
     * @Route("/places", name="rest_place_index",methods={"GET"})
     */
    public function indexAction()
    {   
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();
        return $this->Json($places);
    }

    /**
     *
     * @Route("/places/{id}", name="rest_place_show",requirements={"id" = "\d+"},methods={"GET"})
     */
    public function showAction(int $id)
    {   
        $place = $this->getDoctrine()
            ->getManager()
            ->getRepository(Place::class)
            ->findOneBy(["random_id"=>$id]);
        
        if(empty($place)){
            return $this->NotFound();
        }       
        
        return $this->Ok($place);
    }

    /**
     *
     * @Route("/place", name="rest_place_new",methods={"POST"})
     */
    public function newAction(Request $request)
    {   
        $data=json_decode($request->getContent(),$jsonAsArray = true);
        if(empty($data) ){
            $err =json_last_error_msg();
            if(!empty($err))
            {
                return $this->Error(["error"=>"Json : ".$err]);
            }
        }

        $place = new Place();

        $form = $this->createForm('AppBundle\Form\PlaceType', $place);
        $form->submit($data);
        if (!$form->isValid()) {
            return $this->FormError($form);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($place);
        $em->flush();
        return $this->Created($place);
    }

    /**
     *
     * @Route("/places/{id}", name="rest_place_edit", requirements={"id" = "\d+"}, methods={"PATCH"})
     */
    public function editAction(Request $request, int $id)
    {   
        $place = $this->getDoctrine()->getManager()->getRepository(Place::class)->findOneBy(["random_id"=>$id]);
        if(empty($place)){
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

        $editForm = $this->createForm('AppBundle\Form\PlaceType', $place);
        $editForm->submit($data);
        if (!$editForm->isValid()) {
            return $this->FormError($editForm);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($place);
        $em->flush();
        return $this->Ok($place);
        
    }

    /**
     *
     * @Route("/places/{id}", name="rest_place_delete",requirements={"id" = "\d+"},methods={"DELETE"})
     */
    public function deleteAction(Request $request, int $id)
    {   
        $place = $this->getDoctrine()->getManager()->getRepository(Place::class)->findOneBy(["random_id"=>$id]);
        if(empty($place)){
            return $this->Deleted();
        }
        $em = $this->getDoctrine()->getManager();
        
        $contacts = $place->contacts;
        foreach($contacts as $contact){
            $em->remove($contact);
            $em->flush(); 
        }
        $em->remove($place);
        $em->flush(); 
         
        return $this->Deleted();
    }

}
