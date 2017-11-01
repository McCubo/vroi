<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AmlCityRepository extends EntityRepository {

    public function getCityListByCountry($iCountryID) {
        $a = $this->getEntityManager()
                ->createQuery("SELECT c FROM AppBundle:AmlCity c WHERE c.citCou = {$iCountryID}")
                ->getResult();
        return $a;
    }

}
