<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AmlProviderRepository extends EntityRepository {

    public function getProviderCountByCountry() {
        $sSqlQuery = "SELECT co.cou_code, count(p.pro_id) as counter"
                . " FROM db_alg.aml_provider p"
                . " inner join aml_city c on c.cit_id = p.pro_cit_id"
                . " inner join aml_country co on co.cou_id = c.cit_cou_id"
                . " group by co.cou_code;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();        
        $aData = array();
        foreach ($stmt->fetchAll() as $record) {
            $aData[$record["cou_code"]] = $record["counter"];
        }
        return $aData;
    }

    public function getAllBut($proID) {
        $result = $this->getEntityManager()->createQuery("SELECT p FROM AppBundle:AmlProvider p WHERE p.proId NOT IN (:id)")
                ->setParameter('id', array($proID), \Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
                ->getResult();
        return $result;
    }

    public function getProviderRankList() {
        $sSqlQuery = "select
                pro.pro_id, pro.pro_name, avg(pes.pes_score) as rating, 
                pro.pro_site_url,pro.pro_main_phone_number,cou.cou_name,
                GROUP_CONCAT(DISTINCT srv.ser_name SEPARATOR ', ') services
                from aml_provider pro
                inner join aml_provider_evaluation pre ON pre.pre_pro_id = pro.pro_id
                inner join aml_provider_eval_score pes ON pes.pes_pre_id = pre.pre_id
                inner join aml_city cit ON pro.pro_cit_id = cit.cit_id
                inner join aml_country cou ON cou.cou_id = cit.cit_cou_id
                left join  aml_provider_service srvpro ON pro.pro_id = srvpro.prs_pro_id
                left join aml_service srv ON srvpro.prs_ser_id = srv.ser_id
                group by pro.pro_id, pro.pro_name, pro.pro_address";

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
        $sSqlQuery = "select pes.pes_evp_id, avg(pes.pes_score) as rating from aml_provider pro"
                . " inner join aml_provider_evaluation pre ON pre.pre_pro_id = pro.pro_id"
                . " inner join aml_provider_eval_score pes ON pes.pes_pre_id = pre.pre_id"
                . " WHERE pro.pro_id = {$proID}"
                . " group by pro.pro_id, pes.pes_evp_id;";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();
        $aResult = $stmt->fetchAll();
        $aData = array();
        foreach ($aResult as $aRecord) {
            $aData[$aRecord["pes_evp_id"]]["score"] = round($aRecord["rating"], 3);
            $sClass = "green";
            if ($aRecord["rating"] >= 2.5 && $aRecord["rating"] <= 4.0) {
                $sClass = "orange";
            } elseif ($aRecord["rating"] < 2.5) {
                $sClass = "red";
            }
            $aData[$aRecord["pes_evp_id"]]["class"] = $sClass;
        }
        return $aData;
    }

    public function getProviderArrayById($proID) {
        $sQuery = "SELECT p.pro_id, p.pro_name, p.pro_address, c.cit_name, co.cou_name, p.pro_main_phone_number,"
                . " p.pro_site_url, g.prg_name, t.prt_name, af.pra_name, p.pro_description,"
                . " p.pro_fax"
                . " FROM db_alg.aml_provider p"
                . " inner join aml_city c ON c.cit_id = p.pro_cit_id"
                . " inner join aml_country co ON co.cou_id = c.cit_cou_id"
                . " inner join aml_provider_group g ON g.prg_id = p.pro_prg_id"
                . " inner join aml_provider_type t ON t.prt_id = p.pro_prt_id"
                . " inner join aml_provider_afiliation af ON af.pra_id = p.pro_pra_id"
                . " where p.pro_id = {$proID}";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sQuery);
        $stmt->execute();
        $aResult = $stmt->fetchAll();
        $aProvider = $aResult[0];
        $aProvider["contact_list"] = $this->getContactListByProId($proID);
        $aProvider["relation_list"] = $this->getRelationByProId($proID);
        $aProvider["service_list"] = $this->getServiceListByProID($proID);
        return $aProvider;
    }

    private function getContactListByProId($proID) {
        $sQuery = "SELECT * FROM db_alg.aml_provider_contact c where c.prc_pro_id = {$proID};";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sQuery);
        $stmt->execute();
        $aResult = $stmt->fetchAll();
        return $aResult;
    }

    private function getRelationByProId($proID) {
        $aData = array();
        $sQuery = "SELECT r.prr_child_pro_id FROM db_alg.aml_provider_relation r WHERE r.prr_parent_pro_id = {$proID};";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sQuery);
        $stmt->execute();
        $aResult = $stmt->fetchAll();
        foreach ($aResult as $value) {
            array_push($aData, $value["prr_child_pro_id"]);
        }
        return $aData;
    }

    private function getServiceListByProID($proID) {
        $aData = array();
        $sQuery = "SELECT s.prs_ser_id FROM db_alg.aml_provider_service s where s.prs_pro_id = {$proID};";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sQuery);
        $stmt->execute();
        $aResult = $stmt->fetchAll();
        foreach ($aResult as $value) {
            array_push($aData, $value["prs_ser_id"]);
        }
        return $aData;
    }

}