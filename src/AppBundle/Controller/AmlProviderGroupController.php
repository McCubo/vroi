<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlProviderGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amlprovidergroup controller.
 *
 * @Route("admin/provider/group")
 */
class AmlProviderGroupController extends Controller {

    /**
     * Lists all amlProviderGroup entities.
     *
     * @Route("/", name="admin_provider_group_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $amlProviderGroups = $em->getRepository('AppBundle:AmlProviderGroup')->findAll();

        return $this->render('amlprovidergroup/index.html.twig', array(
                    'amlProviderGroups' => $amlProviderGroups,
        ));
    }

    /**
     * Creates a new amlProviderGroup entity.
     *
     * @Route("/new", name="admin_provider_group_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $amlProviderGroup = new Amlprovidergroup();
        $form = $this->createForm('AppBundle\Form\AmlProviderGroupType', $amlProviderGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlProviderGroup);
            $em->flush();

            return $this->redirectToRoute('admin_provider_group_index', array('prgId' => $amlProviderGroup->getPrgid()));
        }

        return $this->render('amlprovidergroup/new.html.twig', array(
                    'amlProviderGroup' => $amlProviderGroup,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlProviderGroup entity.
     *
     * @Route("/{prgId}/edit", name="admin_provider_group_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlProviderGroup $amlProviderGroup) {
        $editForm = $this->createForm('AppBundle\Form\AmlProviderGroupType', $amlProviderGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_provider_group_index');
        }

        return $this->render('amlprovidergroup/edit.html.twig', array(
                    'amlProviderGroup' => $amlProviderGroup,
                    'edit_form' => $editForm->createView(),
        ));
    }

}
