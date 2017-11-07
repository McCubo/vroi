<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HomeController extends Controller {

    /**
     * @Route("/", name="home")
     * @Security("has_role('ROLE_USER')")
     */
    public function homeAction(Request $request) {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $amlProviderList = $em->getRepository('AppBundle:AmlProvider')->getProviderRankList();

        return $this->render("amlhome/index.html.twig", array(
                    "amlProviderList" => $amlProviderList
        ));
    }

    /**
     * 
     * @Route("/provider/{proId}/edit", name="provider_edit")
     * @Security("has_role('ROLE_USER')")
     */
    public function showProviderAction(Request $request, $proId) {
        $em = $this->getDoctrine()->getManager();
        $amlProvider = $em->getRepository('AppBundle:AmlProvider')->find($proId);
        if (is_null($amlProvider)) {
            throw $this->createNotFoundException("Provider not Found");
        }
        $amlEvaluationPoints = $em->getRepository("AppBundle:AmlEvaluationPoint")->findBy(array("evpStatus" => 1));
        $iCurrentScoreAvg = $em->getRepository('AppBundle:AmlProvider')->getProviderRankById($proId);
        $aCurrentScoreAvgPoint = $em->getRepository('AppBundle:AmlProvider')->getProviderRankByIdAndPoint($proId);

        return $this->render("amlhome/show_provider.html.twig", array(
                    "amlProvider" => $amlProvider,
                    "amlEvaluationPoints" => $amlEvaluationPoints,
                    "iCurrentScoreAvg" => $iCurrentScoreAvg[0]["rating"],
                    "aCurrentScoreAvgPoint" => $aCurrentScoreAvgPoint
        ));
    }

}
