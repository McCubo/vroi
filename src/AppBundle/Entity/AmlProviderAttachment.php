<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderAttachment
 *
 * @ORM\Table(name="aml_provider_attachment", indexes={@ORM\Index(name="FK_provider_file_use_id", columns={"pat_use_id"}), @ORM\Index(name="FK_provider_file_pro_id", columns={"pat_pro_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderAttachment {

    /**
     * @var string
     *
     * @ORM\Column(name="pat_comment", type="string", length=250, nullable=false)
     */
    private $patComment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pat_upload_date", type="datetime", nullable=false)
     */
    private $patUploadDate;

    /**
     * @var string
     *
     * @ORM\Column(name="pat_file_path", type="string", length=250, nullable=false)
     */
    private $patFilePath;

    /**
     * @var integer
     *
     * @ORM\Column(name="pat_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $patId;

    /**
     * @var \AppBundle\Entity\AmlProvider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProvider")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pat_pro_id", referencedColumnName="pro_id")
     * })
     */
    private $patPro;

    /**
     * @var \AppBundle\Entity\AmlUser
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pat_use_id", referencedColumnName="use_id")
     * })
     */
    private $patUse;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->patUploadDate = new \DateTime();
    }

    function getPatComment() {
        return $this->patComment;
    }

    function getPatUploadDate(): \DateTime {
        return $this->patUploadDate;
    }

    function getPatFilePath() {
        return $this->patFilePath;
    }

    function getPatId() {
        return $this->patId;
    }

    function getPatPro(): \AppBundle\Entity\AmlProvider {
        return $this->patPro;
    }

    function getPatUse(): \AppBundle\Entity\AmlUser {
        return $this->patUse;
    }

    function setPatComment($patComment) {
        $this->patComment = $patComment;
    }

    function setPatUploadDate(\DateTime $patUploadDate) {
        $this->patUploadDate = $patUploadDate;
    }

    function setPatFilePath($patFilePath) {
        $this->patFilePath = $patFilePath;
    }

    function setPatId($patId) {
        $this->patId = $patId;
    }

    function setPatPro(\AppBundle\Entity\AmlProvider $patPro) {
        $this->patPro = $patPro;
    }

    function setPatUse(\AppBundle\Entity\AmlUser $patUse) {
        $this->patUse = $patUse;
    }

}
