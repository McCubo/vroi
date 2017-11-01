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
use AppBundle\Entity\AmlProviderFeedback;
use AppBundle\Entity\AmlProviderContact;
use AppBundle\Entity\AmlProviderService;
use AppBundle\Entity\AmlProviderRelation;

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
     * @Route("/admin/provider_save", name="provider_save")
     */
    public function doSaveAction(Request $request) {
        $user = $this->getUser();
        $uploadFile = new UploadFile();
        $form = $this->createForm(UploadFileType::class, $uploadFile);
        $form->handleRequest($request);
        $oFile = $uploadFile->getFileDoc();
        $clientOriginalName = $oFile->getClientOriginalName();

        $file = $request->files->get("file_doc");
        # $file2 = $request->files->get("file");
        # $all0 = $request->files->all();
        /*
          if ($file != null) {
          print_r("FILE!");
          }
         */
        $aFormParameter = $request->request->all();

        $amlProvider = new AmlProvider();
        $amlProvider->setProName($aFormParameter['provider']['name']);
        $amlProvider->setProAddress($aFormParameter['provider']['address']);
        $amlProvider->setProCitId(1);
        $amlProvider->setProMainPhoneNumber($aFormParameter['provider']['main_phone']);
        $amlProvider->setProPrgId($aFormParameter['provider']['group']);
        $amlProvider->setProPrtId($aFormParameter['provider']['type']);
        $amlProvider->setProPraId($aFormParameter['provider']['affiliation']);
        $amlProvider->setProDescription($aFormParameter['provider']['description']);
        $amlProvider->setProSiteUrl($aFormParameter['provider']['url']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($amlProvider);
        $em->flush();
        $proId = $amlProvider->getProId();

        $amlProviderEvaluation = new AmlProviderEvaluation();
        $amlProviderEvaluation->setPreProId($proId);
        $amlProviderEvaluation->setPreUseId($user->getUseId());
        $em->persist($amlProviderEvaluation);
        $em->flush();
        $preId = $amlProviderEvaluation->getPreId();

        foreach ($aFormParameter['evaluation'] as $key => $eval) {
            $amlProviderEvalScore = new AmlProviderEvalScore();
            $amlProviderEvalScore->setPesPreId($preId);
            $amlProviderEvalScore->setPesScore($eval);
            $amlProviderEvalScore->setPesEvpId($key);
            $em->persist($amlProviderEvalScore);
            $em->flush();
        }

        $amlProviderFeedback = new AmlProviderFeedback();
        $amlProviderFeedback->setPrfComment($aFormParameter["feedback_text"]);
        $amlProviderFeedback->setPrfProId($proId);
        $amlProviderFeedback->setPrfUseId($user->getUseId());
        $em->persist($amlProviderFeedback);
        $em->flush();

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

        foreach ($aFormParameter["pro_services"] as $iServiceId) {
            $amlProviderService = new AmlProviderService();
            $amlProviderService->setPrsProId($proId);
            $amlProviderService->setPrsSerId($iServiceId);
            $em->persist($amlProviderService);
            $em->flush();
        }

        foreach ($aFormParameter["pro_relations"] as $iProviderID) {
            $amlProviderRelation = new AmlProviderRelation();
            $amlProviderRelation->setPrrParentProId($proId);
            $amlProviderRelation->setPrrChildProId($iProviderID);
            $em->persist($amlProviderRelation);
            $em->flush();
        }
        return $this->redirectToRoute('home');
    }

}
