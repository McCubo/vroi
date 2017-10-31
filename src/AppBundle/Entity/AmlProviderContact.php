<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderContact
 *
 * @ORM\Table(name="aml_provider_contact", indexes={@ORM\Index(name="FK_provider_contact_provider", columns={"prc_pro_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks() 
 */
class AmlProviderContact {

    /**
     * @var string
     *
     * @ORM\Column(name="prc_name", type="string", length=75, nullable=false)
     */
    private $prcName;

    /**
     * @var string
     *
     * @ORM\Column(name="prc_phone_number", type="string", length=25, nullable=false)
     */
    private $prcPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="prc_job_title", type="string", length=50, nullable=false)
     */
    private $prcJobTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="prc_email", type="string", length=175, nullable=false)
     */
    private $prcEmail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prc_created_date", type="datetime", nullable=false)
     */
    private $prcCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prc_updated_date", type="datetime", nullable=true)
     */
    private $prcUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="prc_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prcId;

    /**
     * @var integer
     *
     * @ORM\Column(name="prc_pro_id", type="integer", nullable=true)
     */
    private $prcProId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->prcCreatedDate = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->prcUpdatedDate = new \DateTime();
    }

    function getPrcName() {
        return $this->prcName;
    }

    function getPrcPhoneNumber() {
        return $this->prcPhoneNumber;
    }

    function getPrcJobTitle() {
        return $this->prcJobTitle;
    }

    function getPrcEmail() {
        return $this->prcEmail;
    }

    function getPrcCreatedDate(): \DateTime {
        return $this->prcCreatedDate;
    }

    function getPrcUpdatedDate(): \DateTime {
        return $this->prcUpdatedDate;
    }

    function getPrcId() {
        return $this->prcId;
    }

    function getPrcProId() {
        return $this->prcProId;
    }

    function setPrcName($prcName) {
        $this->prcName = $prcName;
    }

    function setPrcPhoneNumber($prcPhoneNumber) {
        $this->prcPhoneNumber = $prcPhoneNumber;
    }

    function setPrcJobTitle($prcJobTitle) {
        $this->prcJobTitle = $prcJobTitle;
    }

    function setPrcEmail($prcEmail) {
        $this->prcEmail = $prcEmail;
    }

    function setPrcCreatedDate(\DateTime $prcCreatedDate) {
        $this->prcCreatedDate = $prcCreatedDate;
    }

    function setPrcUpdatedDate(\DateTime $prcUpdatedDate) {
        $this->prcUpdatedDate = $prcUpdatedDate;
    }

    function setPrcId($prcId) {
        $this->prcId = $prcId;
    }

    function setPrcProId($prcProId) {
        $this->prcProId = $prcProId;
    }

}
