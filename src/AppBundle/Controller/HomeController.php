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
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\UploadFile;
use AppBundle\Form\UploadFileType;
use AppBundle\Entity\AmlProviderAttachment;

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
     * @Route("/provider/modal/diagonal", name="modal_get_additional")
     */
    public function getAdditionalPartialAction(Request $request) {
        $proId = $request->query->get("proId");
        $em = $this->getDoctrine()->getManager();
        $fileList = $em->getRepository('AppBundle:AmlProviderAttachment')->getAttachmentListByProId($proId);
        $html = $this->renderView("amlhome/additional_info.html.twig", array("fileList" => $fileList, "proId" => $proId));
        return new Response($html);
    }

    /**
     * 
     * @Route("/provider/modal/file/upload/diagonal", name="upload_single_file")
     */
    public function uploadFileAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $aData = array("error_list" => array(), "oData" => array());
        $user = $this->getUser();
        $uploadFile = new UploadFile();
        $form = $this->createForm(UploadFileType::class, $uploadFile);
        $form->handleRequest($request);
        if (!$form->isValid()) {
            foreach ($form->getErrors() as $error) {
                array_push($aData["error_list"], $error->getMessage());
            }
            return new JsonResponse($aData);
        }
        $oFile = $uploadFile->getFileDoc();
        $fileName = md5(uniqid()) . '.' . $oFile->guessExtension();
        $aFormParameter = $request->request->all();
        $amlProvider = $em->getRepository('AppBundle:AmlProvider')->find($aFormParameter["provider"]["id"]);
        $amlProviderAttachment = new AmlProviderAttachment();
        $amlProviderAttachment->setPatComment($oFile->getClientOriginalName());
        $amlProviderAttachment->setPatPro($amlProvider);
        $amlProviderAttachment->setPatUse($user);
        $amlProviderAttachment->setPatFilePath($fileName);
        $amlProviderAttachment->setPatOriginalName($oFile->getClientOriginalName());
        $em->persist($amlProviderAttachment);
        $em->flush();
        $oFile->move($this->getParameter('provider_file_directory'), $fileName);
        $aData["oData"]["id"] = $amlProviderAttachment->getPatId();
        $aData["oData"]["file_name"] = $oFile->getClientOriginalName();
        $aData["oData"]["file_link"] = $fileName;
        $aData["oData"]["upload_date"] = $amlProviderAttachment->getPatUploadDate()->format("Y-m-d H:i:s");
        $aData["oData"]["upload_by"] = $user->getPrintValue();
        return new JsonResponse($aData);
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
