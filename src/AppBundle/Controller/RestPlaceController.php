<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 

/**
 * Place controller.
 *
 * @Route("rest_place")
 */
class RestPlaceController extends Controller
{
    /**
     * Lists all place entities.
     *
     * @Route("/", name="rest_place_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $places = $em->getRepository('AppBundle:Place')->findAll();

        $response = new Response(json_encode($places));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Creates a new place entity.
     *
     * @Route("/new", name="rest_place_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm('AppBundle\Form\PlaceType', $place);
        $data=json_decode($request->getContent(),true);
        $content= $request->getContent();
        $form->submit($data);
        //dump($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();
        }

        $response = new Response(json_encode($place));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        
    }


    /**
     * Displays a form to edit an existing place entity.
     *
     * @Route("/{id}/edit", name="rest_place_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Place $place)
    {   
        if($request->isMethod('get')){
            $response = new Response(json_encode($place));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        if($request->isMethod('post')){
            $editForm = $this->createForm('AppBundle\Form\PlaceType', $place);
            $data=json_decode($request->getContent(),true);
            $editForm->submit($data);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $response = new Response(json_encode($place));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }

        return $this->render('place/edit.html.twig', array(
            'place' => $place,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a place entity.
     *
     * @Route("/{id}", name="rest_place_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Place $place)
    { 
        $em = $this->getDoctrine()->getManager();
        dump($em);
        $em->remove($place);
        $em->flush();
        $response = new Response(null,Response::HTTP_NO_CONTENT);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
