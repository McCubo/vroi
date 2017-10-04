<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/temp", name="home")
     */
    public function homeAction(Request $request) {
        return $this->render("temp/temp.html.twig");
    }

    /**
     * @Route("/", name="temp")
     */
    public function tempAction(Request $request) {
        return $this->render("temp/temp.html.twig");
    }
}
