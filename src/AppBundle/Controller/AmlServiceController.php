<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Amlservice controller.
 *
 * @Route("admin/service")
 */
class AmlServiceController extends Controller
{
    /**
     * Lists all amlService entities.
     *
     * @Route("/", name="admin_service_index")
     * @Method("GET")
     */
    public function indexAction()
    {
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
    public function newAction(Request $request)
    {
        $amlService = new Amlservice();
        $form = $this->createForm('AppBundle\Form\AmlServiceType', $amlService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlService);
            $em->flush();

            return $this->redirectToRoute('admin_service_show', array('serId' => $amlService->getSerid()));
        }

        return $this->render('amlservice/new.html.twig', array(
            'amlService' => $amlService,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a amlService entity.
     *
     * @Route("/{serId}", name="admin_service_show")
     * @Method("GET")
     */
    public function showAction(AmlService $amlService)
    {
        $deleteForm = $this->createDeleteForm($amlService);

        return $this->render('amlservice/show.html.twig', array(
            'amlService' => $amlService,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlService entity.
     *
     * @Route("/{serId}/edit", name="admin_service_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlService $amlService)
    {
        $deleteForm = $this->createDeleteForm($amlService);
        $editForm = $this->createForm('AppBundle\Form\AmlServiceType', $amlService);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_service_edit', array('serId' => $amlService->getSerid()));
        }

        return $this->render('amlservice/edit.html.twig', array(
            'amlService' => $amlService,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a amlService entity.
     *
     * @Route("/{serId}", name="admin_service_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AmlService $amlService)
    {
        $form = $this->createDeleteForm($amlService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($amlService);
            $em->flush();
        }

        return $this->redirectToRoute('admin_service_index');
    }

    /**
     * Creates a form to delete a amlService entity.
     *
     * @param AmlService $amlService The amlService entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AmlService $amlService)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_service_delete', array('serId' => $amlService->getSerid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
