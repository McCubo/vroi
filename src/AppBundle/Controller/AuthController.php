<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller {

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', array(
                    'last_username' => $lastUsername,
                    'error' => $error,
        ));
    }

    /**
     * 
     * @Route("/confirm/{token}", name="user_confirm")
     * @Method({"GET", "POST"})
     */
    public function confirmAction(Request $request, $token) {
        $em = $this->getDoctrine()->getManager();
        $amlUser = $em->getRepository('AppBundle:AmlUser')->findOneBy(array('useToken' => $token));
        if ($amlUser == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $amlUser->setUseConfirmationDate(new \DateTime());
        $em->persist($amlUser);
        $em->flush();
        return $this->render("security/confirm.html.twig");
    }

}
