<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 

class RestPlaceController extends Controller
{
    /**
     *
     * @Route("/places", name="rest_place_index",methods={"GET"})
     *
     */
    public function indexAction()
    {   
        $s = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();
        $response = new Response($s->serialize($places,'json'), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

      /**
     * Finds and displays a place entity.
     *
     * @Route("/places/{id}", name="rest_place_show",requirements={"id" = "\d+"},methods={"GET"})
     */
    public function showAction(int $id)
    {   
        $place = $this->getDoctrine()->getManager()->getRepository(Place::class)->findOneBy(["random_id"=>$id]);
        if(empty($place)){
            return 1;
        }
        $s = $this->get('jms_serializer');
        $response = new Response($s->serialize($place,'json'), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new place entity.
     *
     * @Route("/place", name="rest_place_new",methods={"POST"})
     */
    public function newAction(Request $request)
    {
        $place = new Place();
        $s = $this->get('jms_serializer');
        $form = $this->createForm('AppBundle\Form\PlaceType', $place);
        $data=json_decode($request->getContent(),true);
        $content= $request->getContent();
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();
            $response = new Response($s->serialize($place,'json'), Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $response = new Response($s->serialize(array("error" => "the form is invalid"),'json'), Response::HTTP_BAD_REQUEST );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        
    }

 

    /**
     * Displays a form to edit an existing place entity.
     *
     * @Route("/places/{id}", name="rest_place_edit",methods={"PATCH"})
     */
    public function editAction(Request $request, Place $place)
    {   
        $s = $this->get('jms_serializer');
        if($request->isMethod('patch')){
            $editForm = $this->createForm('AppBundle\Form\PlaceType', $place);
            $data=json_decode($request->getContent(),true);
            $editForm->submit($data);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $response = new Response($s->serialize($place,'json'), Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }
        else{
             $response = new Response($s->serialize(array("error" => "the form is invalid"),'json'), Response::HTTP_BAD_REQUEST );
                $response->headers->set('Content-Type', 'application/json');
                return $response;
        }
    }

    /**
     * Deletes a place entity.
     *
     * @Route("/places/{id}", name="rest_place_delete",requirements={"id" = "\d+"},methods={"DELETE"})
     */
    public function deleteAction(Request $request, Place $place)
    { 
        $em = $this->getDoctrine()->getManager();
        $em->remove($place);
        $em->flush();
        $response = new Response(null,Response::HTTP_NO_CONTENT);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
