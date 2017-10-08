<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller {

    /**
     * @Route("/", name="home")
     * @Security("has_role('ROLE_USER')")
     */
    public function homeAction(Request $request) {
        return $this->render("temp/temp.html.twig");
    }

    /**
     * @Route("/temp", name="temp")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function tempAction(Request $request) {
        return $this->render("temp/temp.html.twig");
    }
}
