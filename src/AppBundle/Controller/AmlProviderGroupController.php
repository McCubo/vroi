<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlProviderGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Amlprovidergroup controller.
 *
 * @Route("admin/provider/group")
 */
class AmlProviderGroupController extends Controller
{
    /**
     * Lists all amlProviderGroup entities.
     *
     * @Route("/", name="admin_provider_group_index")
     * @Method("GET")
     */
    public function indexAction()
    {
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
    public function newAction(Request $request)
    {
        $amlProviderGroup = new Amlprovidergroup();
        $form = $this->createForm('AppBundle\Form\AmlProviderGroupType', $amlProviderGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlProviderGroup);
            $em->flush();

            return $this->redirectToRoute('admin_provider_group_show', array('prgId' => $amlProviderGroup->getPrgid()));
        }

        return $this->render('amlprovidergroup/new.html.twig', array(
            'amlProviderGroup' => $amlProviderGroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a amlProviderGroup entity.
     *
     * @Route("/{prgId}", name="admin_provider_group_show")
     * @Method("GET")
     */
    public function showAction(AmlProviderGroup $amlProviderGroup)
    {
        $deleteForm = $this->createDeleteForm($amlProviderGroup);

        return $this->render('amlprovidergroup/show.html.twig', array(
            'amlProviderGroup' => $amlProviderGroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlProviderGroup entity.
     *
     * @Route("/{prgId}/edit", name="admin_provider_group_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlProviderGroup $amlProviderGroup)
    {
        $deleteForm = $this->createDeleteForm($amlProviderGroup);
        $editForm = $this->createForm('AppBundle\Form\AmlProviderGroupType', $amlProviderGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_provider_group_edit', array('prgId' => $amlProviderGroup->getPrgid()));
        }

        return $this->render('amlprovidergroup/edit.html.twig', array(
            'amlProviderGroup' => $amlProviderGroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a amlProviderGroup entity.
     *
     * @Route("/{prgId}", name="admin_provider_group_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AmlProviderGroup $amlProviderGroup)
    {
        $form = $this->createDeleteForm($amlProviderGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($amlProviderGroup);
            $em->flush();
        }

        return $this->redirectToRoute('admin_provider_group_index');
    }

    /**
     * Creates a form to delete a amlProviderGroup entity.
     *
     * @param AmlProviderGroup $amlProviderGroup The amlProviderGroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AmlProviderGroup $amlProviderGroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_provider_group_delete', array('prgId' => $amlProviderGroup->getPrgid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
