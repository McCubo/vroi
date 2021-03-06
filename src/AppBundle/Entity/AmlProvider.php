<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProvider
 *
 * @ORM\Table(name="aml_provider", uniqueConstraints={@ORM\UniqueConstraint(name="pro_name_UNIQUE", columns={"pro_name"})}, indexes={@ORM\Index(name="FK_provider_afiliation", columns={"pro_pra_id"}), @ORM\Index(name="FK_provider_group", columns={"pro_prg_id"}), @ORM\Index(name="FK_provider_type", columns={"pro_prt_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AmlProviderRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProvider {

    /**
     * @var string
     *
     * @ORM\Column(name="pro_fax", type="string", length=45, nullable=false)
     */
    private $proFax;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_name", type="string", length=45, nullable=false)
     */
    private $proName;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_address", type="string", length=250, nullable=false)
     */
    private $proAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_main_phone_number", type="string", length=45, nullable=false)
     */
    private $proMainPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_site_url", type="string", length=200, nullable=true)
     */
    private $proSiteUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_description", type="string", length=250, nullable=true)
     */
    private $proDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pro_status", type="boolean", nullable=false)
     */
    private $proStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pro_created_date", type="datetime", nullable=false)
     */
    private $proCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pro_updated_date", type="datetime", nullable=true)
     */
    private $proUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_pra_id", type="integer", nullable=true)
     */
    private $proPraId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_cit_id", type="integer", nullable=true)
     */
    private $proCitId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_prg_id", type="integer", nullable=true)
     */
    private $proPrgId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_prt_id", type="integer", nullable=true)
     */
    private $proPrtId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->proCreatedDate = new \DateTime();
        $this->proStatus = 1;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->proUpdatedDate = new \DateTime();
    }

    function getProName() {
        return $this->proName;
    }

    function getProAddress() {
        return $this->proAddress;
    }

    function getProMainPhoneNumber() {
        return $this->proMainPhoneNumber;
    }

    function getProSiteUrl() {
        return $this->proSiteUrl;
    }

    function getProDescription() {
        return $this->proDescription;
    }

    function getProStatus() {
        return $this->proStatus;
    }

    function getProCreatedDate() {
        return $this->proCreatedDate;
    }

    function getProUpdatedDate() {
        return $this->proUpdatedDate;
    }

    function getProId() {
        return $this->proId;
    }

    function getProPraId() {
        return $this->proPraId;
    }

    function getProCitId() {
        return $this->proCitId;
    }

    function getProPrgId() {
        return $this->proPrgId;
    }

    function getProPrtId() {
        return $this->proPrtId;
    }

    function setProName($proName) {
        $this->proName = $proName;
    }

    function setProAddress($proAddress) {
        $this->proAddress = $proAddress;
    }

    function setProMainPhoneNumber($proMainPhoneNumber) {
        $this->proMainPhoneNumber = $proMainPhoneNumber;
    }

    function setProSiteUrl($proSiteUrl) {
        $this->proSiteUrl = $proSiteUrl;
    }

    function setProDescription($proDescription) {
        $this->proDescription = $proDescription;
    }

    function setProStatus($proStatus) {
        $this->proStatus = $proStatus;
    }

    function setProCreatedDate(\DateTime $proCreatedDate) {
        $this->proCreatedDate = $proCreatedDate;
    }

    function setProUpdatedDate(\DateTime $proUpdatedDate) {
        $this->proUpdatedDate = $proUpdatedDate;
    }

    function setProId($proId) {
        $this->proId = $proId;
    }

    function setProPraId($proPraId) {
        $this->proPraId = $proPraId;
    }

    function setProCitId($proCitId) {
        $this->proCitId = $proCitId;
    }

    function setProPrgId($proPrgId) {
        $this->proPrgId = $proPrgId;
    }

    function setProPrtId($proPrtId) {
        $this->proPrtId = $proPrtId;
    }

    function getProFax() {
        return $this->proFax;
    }

    function setProFax($proFax) {
        $this->proFax = $proFax;
    }

}
