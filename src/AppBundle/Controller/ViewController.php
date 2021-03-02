<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 *
 * @Route("view")
 */
class ViewController extends Controller
{
    /**
     * @Route("/list", name="view_list")
     * @Method("GET")
     */
    public function listAction()
    {
        return $this->render('view/list.html.twig',[] );
    }
}