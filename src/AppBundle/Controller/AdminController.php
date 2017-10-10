<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller {

    /**
     * @Route("/admin/provider", name="provider_index")
     */
    public function providerAction(Request $request) {
        
    }

    /**
     * @Route("/admin/station", name="station_index")
     */
    public function stationAction(Request $request) {
        
    }

    /**
     * @Route("/admin/provider/type", name="pro_type_index")
     */
    public function providerTypeAction(Request $request) {
        
    }

    /**
     * @Route("/admin/provider/group", name="pro_group_index")
     */
    public function providerGroupAction(Request $request) {
        
    }

    /**
     * @Route("/admin/country", name="country_index")
     */
    public function countryAction(Request $request) {
        
    }

    /**
     * @Route("/admin/city", name="city_index")
     */
    public function cityAction(Request $request) {
        
    }

    /**
     * @Route("/admin/provider/afiliation", name="pro_afiliation_index")
     */
    public function providerAfiliationAction(Request $request) {
        
    }

    /**
     * @Route("/admin/provider/services", name="pro_services_index")
     */
    public function providerServiceAction(Request $request) {
        
    }

    /**
     * @Route("/admin/users", name="user_index")
     */
    public function userAction(Request $request) {
        
    }

}
