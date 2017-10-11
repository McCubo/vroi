<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderAfiliation
 *
 * @ORM\Table(name="aml_provider_afiliation", uniqueConstraints={@ORM\UniqueConstraint(name="afi_name_UNIQUE", columns={"pra_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderAfiliation {

    /**
     * @var string
     *
     * @ORM\Column(name="pra_name", type="string", length=45, nullable=false)
     */
    private $praName;

    /**
     * @var string
     *
     * @ORM\Column(name="pra_description", type="string", length=200, nullable=true)
     */
    private $praDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pra_status", type="boolean", nullable=false)
     */
    private $praStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pra_created_date", type="datetime", nullable=false)
     */
    private $praCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pra_updated_date", type="datetime", nullable=true)
     */
    private $praUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="pra_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $praId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->praCreatedDate = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->praUpdatedDate = new \DateTime();
    }

    function getPraName() {
        return $this->praName;
    }

    function getPraDescription() {
        return $this->praDescription;
    }

    function getPraStatus() {
        return $this->praStatus;
    }

    function getPraCreatedDate() {
        return $this->praCreatedDate;
    }

    function getPraUpdatedDate() {
        return $this->praUpdatedDate;
    }

    function getPraId() {
        return $this->praId;
    }

    function setPraName($praName) {
        $this->praName = $praName;
    }

    function setPraDescription($praDescription) {
        $this->praDescription = $praDescription;
    }

    function setPraStatus($praStatus) {
        $this->praStatus = $praStatus;
    }

    function setPraCreatedDate(\DateTime $praCreatedDate) {
        $this->praCreatedDate = $praCreatedDate;
    }

    function setPraUpdatedDate(\DateTime $praUpdatedDate) {
        $this->praUpdatedDate = $praUpdatedDate;
    }

    function setPraId($praId) {
        $this->praId = $praId;
    }

}
