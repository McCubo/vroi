<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlStation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amlstation controller.
 *
 * @Route("admin/station")
 */
class AmlStationController extends Controller {

    /**
     * Lists all amlStation entities.
     *
     * @Route("/", name="admin_station_index")
     * @Method("GET")
     */
    public function indexAction() {
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
    public function newAction(Request $request) {
        $amlStation = new Amlstation();
        $form = $this->createForm('AppBundle\Form\AmlStationType', $amlStation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlStation);
            $em->flush();

            return $this->redirectToRoute('admin_station_index');
        }

        return $this->render('amlstation/new.html.twig', array(
                    'amlStation' => $amlStation,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlStation entity.
     *
     * @Route("/{staId}/edit", name="admin_station_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlStation $amlStation) {
        $editForm = $this->createForm('AppBundle\Form\AmlStationType', $amlStation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_station_index');
        }

        return $this->render('amlstation/edit.html.twig', array(
                    'amlStation' => $amlStation,
                    'form' => $editForm->createView(),
        ));
    }

}
