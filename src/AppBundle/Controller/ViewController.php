<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("view")
 */
class ViewController extends Controller
{
    /**
     * @Route("/", name="view_list")
     * @Method("GET")
     */
    public function listAction()
    {
        return $this->render('view/list.html.twig',[] );
    }

    /**
     * @Route("/new", name="view_new")
     * @Method("GET")
     */
    public function newAction()
    {
        return $this->render('view/new.html.twig',[] );
    }

    /**
     * @Route("/{id}/edit", name="view_edit")
     * @Method("GET")
     */
    public function editAction(Request $request)
    {
        $id = (int)$request->request->get('row');
        return $this->render('view/edit.html.twig',array($id) );
    }
    /**
     * @Route("/{id}/contacts", name="view_contacts")
     * @Method("GET")
     */
    public function contactsAction(Request $request)
    {
        $id = (int)$request->request->get('row');
        return $this->render('view/contacts.html.twig',array($id) );
    }

}