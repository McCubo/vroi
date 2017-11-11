<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AmlProviderServiceRepository extends EntityRepository {

    public function deleteByProviderId($proID) {
        $sSqlQuery = "DELETE FROM aml_provider_service WHERE prs_pro_id='{$proID}';";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();
    }

}
