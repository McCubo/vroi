<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AmlProviderRelationRepository extends EntityRepository {

    public function deleteByProviderId($proID) {
        $sSqlQuery = "DELETE FROM aml_provider_relation WHERE prr_parent_pro_id='{$proID}';";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();
    }

}
