<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\AmlProviderEvaluation;
use AppBundle\Entity\AmlProviderEvalScore;
use AppBundle\Entity\AmlProviderContact;
use AppBundle\Entity\AmlProviderService;
use AppBundle\Entity\AmlProviderRelation;

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
        $aProvider = $em->getRepository('AppBundle:AmlProvider')->getProviderArrayById($proId);
        $amlProviders = $em->getRepository('AppBundle:AmlProvider')->getAllBut($proId);
        $amlServices = $em->getRepository('AppBundle:AmlService')->findAll();

        return $this->render("amlhome/show_provider.html.twig", array(
                    "amlProvider" => $amlProvider,
                    "amlEvaluationPoints" => $amlEvaluationPoints,
                    "iCurrentScoreAvg" => $iCurrentScoreAvg[0]["rating"],
                    "aCurrentScoreAvgPoint" => $aCurrentScoreAvgPoint,
                    "aProvider" => $aProvider,
                    "amlProviders" => $amlProviders,
                    "amlServices" => $amlServices
        ));
    }

    /**
     * 
     * @Route("/provider/contact/delete", name="delete_provider_contact")
     */
    public function deleteProContactAction(Request $request) {
        $aData = array("error_list" => array());
        $prcId = $request->query->get("prcId");
        try {
            $em = $this->getDoctrine()->getManager();
            $oProContact = $em->getRepository('AppBundle:AmlProviderContact')->find($prcId);
            $em->remove($oProContact);
            $em->flush();
        } catch (Exception $exc) {
            array_push($aData["error_list"], $exc->getCode() . "::" . $exc->getMessage());
        }

        return new JsonResponse($aData);
    }

    /**
     * 
     * @Route("/provider/edit/diagonal", name="edit_provider_action")
     */
    public function doSaveProviderAction(Request $request) {
        $aData = array("error_list" => array());
        $aFormParameter = $request->request->all();
        $user = $this->getUser();

        $proId = $aFormParameter["provider"]["id"];
        $em = $this->getDoctrine()->getManager();

        // Adding a new evaluation
        $amlProviderEvaluation = new AmlProviderEvaluation();
        $amlProviderEvaluation->setPreProId($proId);
        $amlProviderEvaluation->setPreUseId($user->getUseId());
        $em->persist($amlProviderEvaluation);
        $em->flush();
        $preId = $amlProviderEvaluation->getPreId();
        //  Adding scores to the evaluation
        foreach ($aFormParameter['evaluation'] as $key => $eval) {
            $amlProviderEvalScore = new AmlProviderEvalScore();
            $amlProviderEvalScore->setPesPreId($preId);
            $amlProviderEvalScore->setPesScore($eval);
            $amlProviderEvalScore->setPesEvpId($key);
            $em->persist($amlProviderEvalScore);
            $em->flush();
        }
        // Adding a list of contacts
        if (array_key_exists("contact", $aFormParameter)) {
            foreach ($aFormParameter["contact"] as $contact) {
                $amlProviderContact = new AmlProviderContact();
                $amlProviderContact->setPrcName($contact["name"]);
                $amlProviderContact->setPrcPhoneNumber($contact["phone"]);
                $amlProviderContact->setPrcJobTitle($contact["job_title"]);
                $amlProviderContact->setPrcEmail($contact["email"]);
                $amlProviderContact->setPrcProId($proId);
                $em->persist($amlProviderContact);
                $em->flush();
            }
        }
        $em->getRepository('AppBundle:AmlProviderService')->deleteByProviderId($proId);
        // If there is any service, Insert them
        if (array_key_exists("pro_services", $aFormParameter)) {
            foreach ($aFormParameter["pro_services"] as $iServiceId) {
                $amlProviderService = new AmlProviderService();
                $amlProviderService->setPrsProId($proId);
                $amlProviderService->setPrsSerId($iServiceId);
                $em->persist($amlProviderService);
                $em->flush();
            }
        }
        $em->getRepository('AppBundle:AmlProviderRelation')->deleteByProviderId($proId);
        if (array_key_exists("pro_relations", $aFormParameter)) {
            foreach ($aFormParameter["pro_relations"] as $iProviderID) {
                $amlProviderRelation = new AmlProviderRelation();
                $amlProviderRelation->setPrrParentProId($proId);
                $amlProviderRelation->setPrrChildProId($iProviderID);
                $em->persist($amlProviderRelation);
                $em->flush();
            }
        }
        return new JsonResponse($aData);
    }

}
