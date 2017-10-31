<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amluser controller.
 *
 * @Route("admin/user")
 */
class AmlUserController extends Controller {

    /**
     * Lists all amlUser entities.
     *
     * @Route("/", name="admin_user_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $amlUsers = $em->getRepository('AppBundle:AmlUser')->findAll();

        return $this->render('amluser/index.html.twig', array(
                    'amlUsers' => $amlUsers,
        ));
    }

    /**
     * Creates a new amlUser entity.
     *
     * @Route("/new", name="admin_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {       
        $amlUser = new Amluser();
        $form = $this->createForm('AppBundle\Form\AmlUserType', $amlUser);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $encoder = $this->container->get('security.password_encoder');
            #   $encoded = $encoder->encodePassword($amlUser, $request->request->get("useName"));
            $sToken = md5(random_bytes(30));
            $amlUser->setUseToken($sToken);
            $aForm = $request->request->get("appbundle_amluser");
            $encoded = $encoder->encodePassword($amlUser, $aForm['useName']);
            $amlUser->setUsePassword($encoded);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($amlUser);
                $em->flush();
                $message = (new \Swift_Message('Confirmation Registration for Database Feedback System.'))
                        ->setFrom('system.noreply@amlog.com')
                        ->setTo($amlUser->getUseEmail())
                        ->setBody($this->renderView('notification/confirm_reg.html.twig', array(
                            "email" => $amlUser->getUseEmail(),
                            'name' => $amlUser->getUsername(),
                            "token" => $sToken)), 'text/html');

                $this->get('mailer')->send($message);
                return $this->redirectToRoute('admin_user_index');
            }
        }


        return $this->render('amluser/new.html.twig', array(
                    'amlUser' => $amlUser,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlUser entity.
     *
     * @Route("/{useId}/edit", name="admin_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlUser $amlUser) {
        $editForm = $this->createForm('AppBundle\Form\AmlUserType', $amlUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('amluser/edit.html.twig', array(
                    'amlUser' => $amlUser,
                    'form' => $editForm->createView(),
        ));
    }

}
