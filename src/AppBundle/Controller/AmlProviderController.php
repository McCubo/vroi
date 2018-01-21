<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\AmlProvider;
use AppBundle\Entity\UploadFile;
use AppBundle\Form\UploadFileType;
use AppBundle\Entity\AmlProviderEvaluation;
use AppBundle\Entity\AmlProviderEvalScore;
use AppBundle\Entity\AmlProviderContact;
use AppBundle\Entity\AmlProviderService;
use AppBundle\Entity\AmlProviderRelation;
use AppBundle\Entity\AmlProviderAttachment;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\AmlProviderFeedback;

class AmlProviderController extends Controller {

    /**
     * @Route("/admin/provider", name="provider_index")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $amlServices = $em->getRepository('AppBundle:AmlService')->findAll();
        $amlCountries = $em->getRepository('AppBundle:AmlCountry')->findAll();
        $amlGroups = $em->getRepository('AppBundle:AmlProviderGroup')->findBy(array("prgStatus" => 1));
        $amlProvidersType = $em->getRepository('AppBundle:AmlProviderType')->findBy(array("prtStatus" => 1));
        $amlAffiliation = $em->getRepository('AppBundle:AmlProviderAfiliation')->findBy(array("praStatus" => 1));
        $amlProviders = $em->getRepository('AppBundle:AmlProvider')->findAll();
        $amlEvaluationPoints = $em->getRepository("AppBundle:AmlEvaluationPoint")->findBy(array("evpStatus" => 1));
        return $this->render('amlprovider/new_provider.html.twig', array(
                    'amlServices' => $amlServices,
                    "amlCountries" => $amlCountries,
                    "amlGroups" => $amlGroups,
                    "amlProvidersType" => $amlProvidersType,
                    "amlAffiliations" => $amlAffiliation,
                    "amlProviders" => $amlProviders,
                    "amlEvaluationPoints" => $amlEvaluationPoints
        ));
    }

    /**
     * 
     * @Route("/admin/provider/get/cities/country", name="get_cities_by_couid")
     */
    public function getCityListByCountry(Request $request) {
        $aData = array();
        $iCountryID = $request->query->get("cou_id");
        $em = $this->getDoctrine()->getManager();
        $amlCities = $em->getRepository('AppBundle:AmlCity')->getCityListByCountry($iCountryID);
        foreach ($amlCities as $amlCity) {
            array_push($aData, array("city_name" => $amlCity->getCitName(), "city_id" => $amlCity->getCitId()));
        }
        return new JsonResponse($aData);
    }

    /**
     * 
     * @Route("/admin/provider/deleto", name="do_delete_provider")
     */
    public function deleteProvider(Request $request) {
        $aData = array("message_list" => array());
        $em = $this->getDoctrine()->getManager();
        $proId = $request->query->get("pro_id");
        $amlProvider = $em->getRepository('AppBundle:AmlProvider')->find($proId);
        if (is_null($amlProvider)) {
            throw $this->createNotFoundException("Provider not Found");
        }
        $em->remove($amlProvider);
        $em->flush();
        return new JsonResponse($aData);
    }

    /**
     * 
     * @Route("/admin/provider_save", name="provider_save")
     */
    public function doSaveAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $aData = array('message_list' => array(), "error_list" => array());
        $user = $this->getUser();
        $uploadFile = new UploadFile();
        $form = $this->createForm(UploadFileType::class, $uploadFile);
        $form->handleRequest($request);
        $oFile = $uploadFile->getFileDoc();

        $aFormParameter = $request->request->all();
        $amlProviders = $em->getRepository('AppBundle:AmlProvider')->findBy(array("proName" => $aFormParameter['provider']['name']));
        if (count($amlProviders) > 0) {
            array_push($aData["error_list"], "There is already a vendor with that name");
            return new JsonResponse($aData);
        }
        $amlProvider = new AmlProvider();
        $amlProvider->setProName($aFormParameter['provider']['name']);
        $amlProvider->setProAddress($aFormParameter['provider']['address']);
        $amlProvider->setProCitId($aFormParameter['provider']['city_id']);
        $amlProvider->setProMainPhoneNumber($aFormParameter['provider']['main_phone']);
        $amlProvider->setProPrgId($aFormParameter['provider']['group']);
        $amlProvider->setProPrtId($aFormParameter['provider']['type']);
        $amlProvider->setProPraId($aFormParameter['provider']['affiliation']);
        $amlProvider->setProDescription($aFormParameter['provider']['description']);
        $amlProvider->setProSiteUrl($aFormParameter['provider']['url']);
        $amlProvider->setProFax($aFormParameter['provider']['fax']);
        $em->persist($amlProvider);
        $em->flush();
        array_push($aData["message_list"], "Vendor ({$aFormParameter['provider']['name']}) was successfully added!");
        $proId = $amlProvider->getProId();

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
        foreach ($aFormParameter["contact"] as $contact) {
            $amlProviderContact = new AmlProviderContact();
            $amlProviderContact->setPrcName($contact["name"]);
            $amlProviderContact->setPrcPhoneNumber($contact["phone"]);
            if (array_key_exists("job_title", $contact) && strlen($contact["job_title"]) > 0) {
                $amlProviderContact->setPrcJobTitle($contact["job_title"]);
            }
            $amlProviderContact->setPrcEmail($contact["email"]);
            $amlProviderContact->setPrcProId($proId);
            $em->persist($amlProviderContact);
            $em->flush();
        }

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


        if (array_key_exists("pro_relations", $aFormParameter)) {
            foreach ($aFormParameter["pro_relations"] as $iProviderID) {
                $amlProviderRelation = new AmlProviderRelation();
                $amlProviderRelation->setPrrParentProId($proId);
                $amlProviderRelation->setPrrChildProId($iProviderID);
                $em->persist($amlProviderRelation);
                $em->flush();
            }
        }

        # Saving feedback
        if (array_key_exists("feedback_text", $aFormParameter) && strlen($aFormParameter["feedback_text"]) > 0) {
            $amlProviderFeedback = new AmlProviderFeedback();
            $amlProviderFeedback->setPrfComment($aFormParameter["feedback_text"]);
            $amlProviderFeedback->setPrfProId($proId);
            $amlProviderFeedback->setPrfUseId($user->getUseId());
            $em->persist($amlProviderFeedback);
            $em->flush();
        }

        if (!is_null($oFile)) {
            $fileName = md5(uniqid()) . '.' . $oFile->guessExtension();
            $sOriginalFileName = $oFile->getClientOriginalName();
            // Saving attachment
            $amlProviderAttachment = new AmlProviderAttachment();
            $amlProviderAttachment->setPatComment($sOriginalFileName);
            $amlProviderAttachment->setPatPro($amlProvider);
            $amlProviderAttachment->setPatUse($user);
            $amlProviderAttachment->setPatFilePath($fileName);
            $amlProviderAttachment->setPatOriginalName($sOriginalFileName);
            $em->persist($amlProviderAttachment);
            $em->flush();
            $oFile->move($this->getParameter('provider_file_directory'), $fileName);
        }

        // Returning JSON response
        return new JsonResponse($aData);
    }

}
