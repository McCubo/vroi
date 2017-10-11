<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AmlCountry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Amlcountry controller.
 *
 * @Route("admin/country")
 */
class AmlCountryController extends Controller
{
    /**
     * Lists all amlCountry entities.
     *
     * @Route("/", name="admin_country_index")
     * @Method("GET")
     */
    public function indexAction()
    {
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
    public function newAction(Request $request)
    {
        $amlCountry = new Amlcountry();
        $form = $this->createForm('AppBundle\Form\AmlCountryType', $amlCountry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amlCountry);
            $em->flush();

            return $this->redirectToRoute('admin_country_show', array('couId' => $amlCountry->getCouid()));
        }

        return $this->render('amlcountry/new.html.twig', array(
            'amlCountry' => $amlCountry,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a amlCountry entity.
     *
     * @Route("/{couId}", name="admin_country_show")
     * @Method("GET")
     */
    public function showAction(AmlCountry $amlCountry)
    {
        $deleteForm = $this->createDeleteForm($amlCountry);

        return $this->render('amlcountry/show.html.twig', array(
            'amlCountry' => $amlCountry,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amlCountry entity.
     *
     * @Route("/{couId}/edit", name="admin_country_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AmlCountry $amlCountry)
    {
        $deleteForm = $this->createDeleteForm($amlCountry);
        $editForm = $this->createForm('AppBundle\Form\AmlCountryType', $amlCountry);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_country_edit', array('couId' => $amlCountry->getCouid()));
        }

        return $this->render('amlcountry/edit.html.twig', array(
            'amlCountry' => $amlCountry,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a amlCountry entity.
     *
     * @Route("/{couId}", name="admin_country_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AmlCountry $amlCountry)
    {
        $form = $this->createDeleteForm($amlCountry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($amlCountry);
            $em->flush();
        }

        return $this->redirectToRoute('admin_country_index');
    }

    /**
     * Creates a form to delete a amlCountry entity.
     *
     * @param AmlCountry $amlCountry The amlCountry entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AmlCountry $amlCountry)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_country_delete', array('couId' => $amlCountry->getCouid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
