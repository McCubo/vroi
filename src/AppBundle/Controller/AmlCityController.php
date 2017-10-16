<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlCity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amlcity controller.
 *
 * @Route("admin/city")
 */
class AmlCityController extends Controller {

    /**
     * Lists all amlCity entities.
     *
     * @Route("/", name="admin_city_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $amlCities = $em->getRepository('AppBundle:AmlCity')->findAll();

        return $this->render('amlcity/index.html.twig', array(
                    'amlCities' => $amlCities,
        ));
    }

    /**
     * Creates a new amlCity entity.
     *
     * @Route("/new", name="admin_city_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $amlCity = new Amlcity();
        $form = $this->createForm('AppBundle\Form\AmlCityType', $amlCity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlCity);
            $em->flush();

            return $this->redirectToRoute('admin_city_index');
        }

        return $this->render('amlcity/new.html.twig', array(
                    'amlCity' => $amlCity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlCity entity.
     *
     * @Route("/{citId}/edit", name="admin_city_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlCity $amlCity) {
        $editForm = $this->createForm('AppBundle\Form\AmlCityType', $amlCity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_city_index');
        }

        return $this->render('amlcity/edit.html.twig', array(
                    'amlCity' => $amlCity,
                    'form' => $editForm->createView(),
        ));
    }

}
