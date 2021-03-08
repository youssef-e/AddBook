<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("view")
 */
class ViewController extends Controller
{
    /**
     * @Route("/", name="view_list",methods={"GET"})
     */
    public function listAction()
    {
        return $this->render('view/list.html.twig',[] );
    }

    /**
     * @Route("/new", name="view_new",methods={"GET"})
     */
    public function newAction()
    {
        return $this->render('view/new.html.twig',[] );
    }

    /**
     * @Route("/{id}/edit", name="view_edit",methods={"GET"})
     */
    public function editAction(Request $request)
    {
        $id = (int)$request->request->get('row');
        return $this->render('view/edit.html.twig',array($id) );
    }
    /**
     * @Route("/{id}/contacts", name="view_contacts",methods={"GET"})
     */
    public function contactsAction(Request $request)
    {
        $id = (int)$request->request->get('row');
        return $this->render('view/contacts.html.twig',array($id) );
    }

}