<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlCountry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amlcountry controller.
 *
 * @Route("admin/country")
 */
class AmlCountryController extends Controller {

    /**
     * Lists all amlCountry entities.
     *
     * @Route("/", name="admin_country_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $amlCountries = $em->getRepository('AppBundle:AmlCountry')->findAll();

        return $this->render('amlcountry/index.html.twig', array(
                    'amlCountries' => $amlCountries,
        ));
    }

    /**
     * Creates a new amlCountry entity.
     *
     * @Route("/new", name="admin_country_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $amlCountry = new Amlcountry();
        $form = $this->createForm('AppBundle\Form\AmlCountryType', $amlCountry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlCountry);
            $em->flush();

            return $this->redirectToRoute('admin_country_index');
        }

        return $this->render('amlcountry/new.html.twig', array(
                    'amlCountry' => $amlCountry,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlCountry entity.
     *
     * @Route("/{couId}/edit", name="admin_country_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlCountry $amlCountry) {
        $editForm = $this->createForm('AppBundle\Form\AmlCountryType', $amlCountry);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_country_index');
        }

        return $this->render('amlcountry/edit.html.twig', array(
                    'amlCountry' => $amlCountry,
                    'form' => $editForm->createView(),
        ));
    }

}
