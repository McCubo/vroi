<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AmlProviderFeedbackRepository extends EntityRepository {

    public function getCommentListByProId($proId) {
        $sSqlQuery = "SELECT f.prf_id as id, f.prf_comment as comment, concat(u.use_name, \" (\", u.use_email, \")\") as use_name, f.prf_date as date"
                . " FROM db_alg.aml_provider_feedback as f"
                . " inner join aml_user u on u.use_id = f.prf_use_id"
                . " where f.prf_pro_id = {$proId}";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
