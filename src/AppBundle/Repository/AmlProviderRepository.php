<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AmlProviderRepository extends EntityRepository {

    public function getProviderRankList() {
        $sSqlQuery = "select"
                . " pro.pro_id, pro.pro_name, avg(pes.pes_score) as rating, "
                . " pro.pro_site_url,pro.pro_main_phone_number,cou.cou_name"
                . " from aml_provider pro"
                . " inner join aml_provider_evaluation pre ON pre.pre_pro_id = pro.pro_id"
                . " inner join aml_provider_eval_score pes ON pes.pes_pre_id = pre.pre_id"
                . " inner join aml_city cit ON pro.pro_cit_id = cit.cit_id"
                . " inner join aml_country cou ON cou.cou_id = cit.cit_cou_id"
                . " group by pro.pro_id, pro.pro_name, pro.pro_address;";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProviderRankById($proID) {
        $sSqlQuery = "select"
                . " avg(pes.pes_score) as rating"
                . " from aml_provider pro"
                . " inner join aml_provider_evaluation pre ON pre.pre_pro_id = pro.pro_id"
                . " inner join aml_provider_eval_score pes ON pes.pes_pre_id = pre.pre_id"
                . " WHERE pro.pro_id = {$proID}"
                . " group by pro.pro_id;";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProviderRankByIdAndPoint($proID) {
        $sSqlQuery = "select "
                . " pes.pes_evp_id,"
                . " avg(pes.pes_score) as rating"
                . " from aml_provider pro"
                . " inner join aml_provider_evaluation pre ON pre.pre_pro_id = pro.pro_id"
                . " inner join aml_provider_eval_score pes ON pes.pes_pre_id = pre.pre_id"
                . " WHERE pro.pro_id = {$proID}"
                . " group by pro.pro_id, pes.pes_evp_id;";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();
        $aResult = $stmt->fetchAll();
        $aData = array();
        foreach ($aResult as $aRecord) {
            $aData[$aRecord["pes_evp_id"]] = $aRecord["rating"];
        }
        return $aData;
    }

}
