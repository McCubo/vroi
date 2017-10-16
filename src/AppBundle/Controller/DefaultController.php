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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        return $this->render("temp/temp.html.twig");
    }

    /**
     * @Route("/temp/admin", name="temp")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function tempAction(Request $request) {
        /*
          $message = (new \Swift_Message('Mail using Swift Mailer and Symfony'))
          ->setFrom('mccubo.spam@gmail.com')
          ->setTo('cubiascaceres@gmail.com')
          ->setBody($this->renderView('notification/confirm_reg.html.twig', array('name' => "McCubo")), 'text/html');

          $this->get('mailer')->send($message);
         */

        return $this->render("notification/confirm_reg.html.twig", array('name' => "McCubo",
                    "email" => "cubiascaceres@gmail.com.sv",
                    "token" => base64_encode(random_bytes(30)),
                    "link" => "http://amlog/web/app.php/user/confirm/token/aksjdhakjh8764jbmb%jsdfjhgshsgfy384234#-AmL06mxvmnbxcmvbn"));
    }

}
