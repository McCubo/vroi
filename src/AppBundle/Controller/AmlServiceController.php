<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amlservice controller.
 *
 * @Route("admin/service")
 */
class AmlServiceController extends Controller {

    /**
     * Lists all amlService entities.
     *
     * @Route("/", name="admin_service_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $amlServices = $em->getRepository('AppBundle:AmlService')->findAll();

        return $this->render('amlservice/index.html.twig', array(
                    'amlServices' => $amlServices,
        ));
    }

    /**
     * Creates a new amlService entity.
     *
     * @Route("/new", name="admin_service_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $amlService = new Amlservice();
        $form = $this->createForm('AppBundle\Form\AmlServiceType', $amlService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlService);
            $em->flush();

            return $this->redirectToRoute('admin_service_index');
        }

        return $this->render('amlservice/new.html.twig', array(
                    'amlService' => $amlService,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlService entity.
     *
     * @Route("/{serId}/edit", name="admin_service_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlService $amlService) {
        $editForm = $this->createForm('AppBundle\Form\AmlServiceType', $amlService);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_service_index');
        }

        return $this->render('amlservice/edit.html.twig', array(
                    'amlService' => $amlService,
                    'form' => $editForm->createView(),
        ));
    }

}
