<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\AmlProvider;
use AppBundle\Entity\UploadFile;
use AppBundle\Form\UploadFileType;
use AppBundle\Entity\AmlProviderEvaluation;

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
        return $this->render('amlprovider/new_provider.html.twig', array(
                    'amlServices' => $amlServices,
                    "amlCountries" => $amlCountries,
                    "amlGroups" => $amlGroups,
                    "amlProvidersType" => $amlProvidersType,
                    "amlAffiliations" => $amlAffiliation,
                    "amlProviders" => $amlProviders
        ));
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
        
        
        
        return $this->redirectToRoute('home');
        
    }

}
