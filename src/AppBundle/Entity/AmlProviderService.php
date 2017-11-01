<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderService
 *
 * @ORM\Table(name="aml_provider_service", indexes={@ORM\Index(name="FK_provider_service", columns={"prs_ser_id"}), @ORM\Index(name="FK_provider_provider", columns={"prs_pro_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderService {

    /**
     * @var boolean
     *
     * @ORM\Column(name="prs_status", type="boolean", nullable=false)
     */
    private $prsStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prs_created_date", type="datetime", nullable=false)
     */
    private $prsCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prs_updated_date", type="datetime", nullable=true)
     */
    private $prsUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="prs_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="prs_pro_id", type="integer", nullable=false)
     * })
     */
    private $prsProId;

    /**
     * @var integer
     *
     * @ORM\Column(name="prs_ser_id", type="integer", nullable=false)
     * })
     */
    private $prsSerId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->prsStatus = 1;
        $this->prsCreatedDate = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->prsUpdatedDate = new \DateTime();
    }

    function getPrsStatus() {
        return $this->prsStatus;
    }

    function getPrsCreatedDate(): \DateTime {
        return $this->prsCreatedDate;
    }

    function getPrsUpdatedDate(): \DateTime {
        return $this->prsUpdatedDate;
    }

    function getPrsId() {
        return $this->prsId;
    }

    function getPrsProId() {
        return $this->prsProId;
    }

    function getPrsSerId() {
        return $this->prsSerId;
    }

    function setPrsStatus($prsStatus) {
        $this->prsStatus = $prsStatus;
    }

    function setPrsCreatedDate(\DateTime $prsCreatedDate) {
        $this->prsCreatedDate = $prsCreatedDate;
    }

    function setPrsUpdatedDate(\DateTime $prsUpdatedDate) {
        $this->prsUpdatedDate = $prsUpdatedDate;
    }

    function setPrsId($prsId) {
        $this->prsId = $prsId;
    }

    function setPrsProId($prsProId) {
        $this->prsProId = $prsProId;
    }

    function setPrsSerId($prsSerId) {
        $this->prsSerId = $prsSerId;
    }

}
