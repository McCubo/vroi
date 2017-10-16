<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlProviderAfiliation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amlproviderafiliation controller.
 *
 * @Route("admin/provider/afiliation")
 */
class AmlProviderAfiliationController extends Controller {

    /**
     * Lists all amlProviderAfiliation entities.
     *
     * @Route("/", name="admin_provider_afiliation_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $amlProviderAfiliations = $em->getRepository('AppBundle:AmlProviderAfiliation')->findAll();

        return $this->render('amlproviderafiliation/index.html.twig', array(
                    'amlProviderAfiliations' => $amlProviderAfiliations,
        ));
    }

    /**
     * Creates a new amlProviderAfiliation entity.
     *
     * @Route("/new", name="admin_provider_afiliation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $amlProviderAfiliation = new Amlproviderafiliation();
        $form = $this->createForm('AppBundle\Form\AmlProviderAfiliationType', $amlProviderAfiliation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlProviderAfiliation);
            $em->flush();

            return $this->redirectToRoute('admin_provider_afiliation_index', array('praId' => $amlProviderAfiliation->getPraid()));
        }

        return $this->render('amlproviderafiliation/new.html.twig', array(
                    'amlProviderAfiliation' => $amlProviderAfiliation,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlProviderAfiliation entity.
     *
     * @Route("/{praId}/edit", name="admin_provider_afiliation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlProviderAfiliation $amlProviderAfiliation) {
        $editForm = $this->createForm('AppBundle\Form\AmlProviderAfiliationType', $amlProviderAfiliation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_provider_afiliation_index', array('praId' => $amlProviderAfiliation->getPraid()));
        }

        return $this->render('amlproviderafiliation/edit.html.twig', array(
                    'amlProviderAfiliation' => $amlProviderAfiliation,
                    'edit_form' => $editForm->createView(),
        ));
    }

}
