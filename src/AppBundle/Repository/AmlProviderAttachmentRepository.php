<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AmlProviderAttachmentRepository extends EntityRepository {

    public function getAttachmentListByProId($proId) {
        $sSqlQuery = "SELECT f.pat_id, f.pat_original_name, f.pat_upload_date, f.pat_file_path, concat(u.use_name, \" (\", u.use_email, \")\") as use_name,"
                . " p.pro_address, p.pro_main_phone_number FROM aml_provider_attachment f"
                . " inner join aml_user u on u.use_id = f.pat_use_id"
                . " inner join aml_provider p on p.pro_id = f.pat_pro_id"
                . " where f.pat_pro_id = {$proId};";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sSqlQuery);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
