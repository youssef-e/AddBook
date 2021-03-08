<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 

/**
 * Place controller.
 *
 * @Route("place")
 */
class RestPlaceController extends Controller
{
    /**
     * Lists all place entities.
     *
     * @Route("/", name="rest_place_index",methods={"GET"})
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();
        $response = new Response(json_encode($places), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

      /**
     * Finds and displays a place entity.
     *
     * @Route("/{id}", name="rest_place_show",requirements={"id" = "\d+"},methods={"GET"})
     */
    public function showAction(Place $place)
    {   
        $s = $this->get('jms_serializer');
        $response = new Response($s->serialize($place,'json'), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new place entity.
     *
     * @Route("/new", name="rest_place_new",methods={"POST"})
     */
    public function newAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm('AppBundle\Form\PlaceType', $place);
        $data=json_decode($request->getContent(),true);
        $content= $request->getContent();
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();
            $response = new Response(json_encode($place), Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $response = new Response(json_encode(array("error" => "the form is invalid")), Response::HTTP_BAD_REQUEST );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        
    }

 

    /**
     * Displays a form to edit an existing place entity.
     *
     * @Route("/{id}/edit", name="rest_place_edit",methods={"PATCH"})
     */
    public function editAction(Request $request, Place $place)
    {   
        if($request->isMethod('patch')){
            $editForm = $this->createForm('AppBundle\Form\PlaceType', $place);
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
     * Deletes a place entity.
     *
     * @Route("/{id}", name="rest_place_delete",requirements={"id" = "\d+"},methods={"DELETE"})
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
