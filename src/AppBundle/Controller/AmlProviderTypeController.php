<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlProviderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amlprovidertype controller.
 *
 * @Route("admin/provider/type")
 */
class AmlProviderTypeController extends Controller {

    /**
     * Lists all amlProviderType entities.
     *
     * @Route("/", name="admin_provider_type_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $amlProviderTypes = $em->getRepository('AppBundle:AmlProviderType')->findAll();

        return $this->render('amlprovidertype/index.html.twig', array(
                    'amlProviderTypes' => $amlProviderTypes,
        ));
    }

    /**
     * Creates a new amlProviderType entity.
     *
     * @Route("/new", name="admin_provider_type_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $amlProviderType = new Amlprovidertype();
        $form = $this->createForm('AppBundle\Form\AmlProviderTypeType', $amlProviderType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlProviderType);
            $em->flush();

            return $this->redirectToRoute('admin_provider_type_index');
        }

        return $this->render('amlprovidertype/new.html.twig', array(
                    'amlProviderType' => $amlProviderType,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlProviderType entity.
     *
     * @Route("/{prtId}/edit", name="admin_provider_type_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlProviderType $amlProviderType) {
        $editForm = $this->createForm('AppBundle\Form\AmlProviderTypeType', $amlProviderType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_provider_type_index');
        }

        return $this->render('amlprovidertype/edit.html.twig', array(
                    'amlProviderType' => $amlProviderType,
                    'edit_form' => $editForm->createView(),
        ));
    }

}
