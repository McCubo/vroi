<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller {

    /**
    * @Route("/", name="login")
    */
    public function loginAction(Request $request)
    {
        return $this->render('security/login.html.twig');
    }

}