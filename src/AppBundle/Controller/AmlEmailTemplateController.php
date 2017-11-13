<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlEmailTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amlemailtemplate controller.
 *
 * @Route("admin/email")
 */
class AmlEmailTemplateController extends Controller {

    /**
     * Lists all amlEmailTemplate entities.
     *
     * @Route("/", name="admin_email_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $amlEmailTemplates = $em->getRepository('AppBundle:AmlEmailTemplate')->findAll();

        return $this->render('amlemailtemplate/index.html.twig', array(
                    'amlEmailTemplates' => $amlEmailTemplates,
        ));
    }

    /**
     * Creates a new amlEmailTemplate entity.
     *
     * @Route("/new", name="admin_email_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $amlEmailTemplate = new Amlemailtemplate();
        $form = $this->createForm('AppBundle\Form\AmlEmailTemplateType', $amlEmailTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlEmailTemplate);
            $em->flush();

            return $this->redirectToRoute('admin_email_index');
        }

        return $this->render('amlemailtemplate/new.html.twig', array(
                    'amlEmailTemplate' => $amlEmailTemplate,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlEmailTemplate entity.
     *
     * @Route("/{emaId}/edit", name="admin_email_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlEmailTemplate $amlEmailTemplate) {
        $editForm = $this->createForm('AppBundle\Form\AmlEmailTemplateType', $amlEmailTemplate);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_email_index');
        }

        return $this->render('amlemailtemplate/edit.html.twig', array(
                    'amlEmailTemplate' => $amlEmailTemplate,
                    'form' => $editForm->createView()
        ));
    }

}
