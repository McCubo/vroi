<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlStation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Amlstation controller.
 *
 * @Route("admin/station")
 */
class AmlStationController extends Controller
{
    /**
     * Lists all amlStation entities.
     *
     * @Route("/", name="admin_station_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $amlStations = $em->getRepository('AppBundle:AmlStation')->findAll();

        return $this->render('amlstation/index.html.twig', array(
            'amlStations' => $amlStations,
        ));
    }

    /**
     * Creates a new amlStation entity.
     *
     * @Route("/new", name="admin_station_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $amlStation = new Amlstation();
        $form = $this->createForm('AppBundle\Form\AmlStationType', $amlStation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlStation);
            $em->flush();

            return $this->redirectToRoute('admin_station_show', array('staId' => $amlStation->getStaid()));
        }

        return $this->render('amlstation/new.html.twig', array(
            'amlStation' => $amlStation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a amlStation entity.
     *
     * @Route("/{staId}", name="admin_station_show")
     * @Method("GET")
     */
    public function showAction(AmlStation $amlStation)
    {
        $deleteForm = $this->createDeleteForm($amlStation);

        return $this->render('amlstation/show.html.twig', array(
            'amlStation' => $amlStation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlStation entity.
     *
     * @Route("/{staId}/edit", name="admin_station_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlStation $amlStation)
    {
        $deleteForm = $this->createDeleteForm($amlStation);
        $editForm = $this->createForm('AppBundle\Form\AmlStationType', $amlStation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_station_edit', array('staId' => $amlStation->getStaid()));
        }

        return $this->render('amlstation/edit.html.twig', array(
            'amlStation' => $amlStation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a amlStation entity.
     *
     * @Route("/{staId}", name="admin_station_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AmlStation $amlStation)
    {
        $form = $this->createDeleteForm($amlStation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($amlStation);
            $em->flush();
        }

        return $this->redirectToRoute('admin_station_index');
    }

    /**
     * Creates a form to delete a amlStation entity.
     *
     * @param AmlStation $amlStation The amlStation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AmlStation $amlStation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_station_delete', array('staId' => $amlStation->getStaid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
