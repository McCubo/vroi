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

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlUser);
            $em->flush();

            return $this->redirectToRoute('admin_user_show', array('useId' => $amlUser->getUseid()));
        }

        return $this->render('amluser/new.html.twig', array(
                    'amlUser' => $amlUser,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a amlUser entity.
     *
     * @Route("/{useId}", name="admin_user_show")
     * @Method("GET")
     */
    public function showAction(AmlUser $amlUser) {
        $deleteForm = $this->createDeleteForm($amlUser);

        return $this->render('amluser/show.html.twig', array(
                    'amlUser' => $amlUser,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlUser entity.
     *
     * @Route("/{useId}/edit", name="admin_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlUser $amlUser) {
        $deleteForm = $this->createDeleteForm($amlUser);
        $editForm = $this->createForm('AppBundle\Form\AmlUserType', $amlUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_edit', array('useId' => $amlUser->getUseid()));
        }

        return $this->render('amluser/edit.html.twig', array(
                    'amlUser' => $amlUser,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a amlUser entity.
     *
     * @Route("/{useId}", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AmlUser $amlUser) {
        $form = $this->createDeleteForm($amlUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($amlUser);
            $em->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * Creates a form to delete a amlUser entity.
     *
     * @param AmlUser $amlUser The amlUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AmlUser $amlUser) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_user_delete', array('useId' => $amlUser->getUseid())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
