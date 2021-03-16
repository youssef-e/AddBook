<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ViewController extends Controller
{
    /**
     * @Route("/view", name="view_list",methods={"GET"})
     */
    public function listAction()
    {
        return $this->render('view/list.html.twig',[] );
    }

    /**
     * @Route("/", name="view_index",methods={"GET"})
     */
    public function indexAction()
    {
        return $this->redirectToRoute('view_list');
    }
    /**
     * @Route("/view/new", name="view_new",methods={"GET"})
     */
    public function newAction()
    {
        return $this->render('view/new.html.twig',[] );
    }

    /**
     * @Route("view/{id}/edit", name="view_edit",methods={"GET"})
     */
    public function editAction(Request $request)
    {
        $id = (int)$request->request->get('row');
        return $this->render('view/edit.html.twig',[]);
    }
    /**
     * @Route("/view/{id}/contacts", name="view_contacts",methods={"GET"})
     */
    public function contactsAction(Request $request)
    {
        $id = (int)$request->request->get('row');
        return $this->render('view/contacts.html.twig',[] );
    }

    /**
     * @Route("/view/places/{id}/contact", name="view_new_contact",methods={"GET"})
     */
    public function newContactAction(int $id)
    {
        return $this->render('view/contactNew.html.twig',[] );
    }

    /**
     * @Route("view/contacts/{id}/edit", name="view_contact_edit",methods={"GET"})
     */
    public function editContactAction(Request $request)
    {
        $id = (int)$request->request->get('row');
        return $this->render('view/contactEdit.html.twig',[] );
    }
}