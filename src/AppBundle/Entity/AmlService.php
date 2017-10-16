<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * AmlService
 *
 * @ORM\Table(name="aml_service", uniqueConstraints={@ORM\UniqueConstraint(name="ser_name_UNIQUE", columns={"ser_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields= {"serName"}, message="There is already a Service with that name!")
 */
class AmlService {

    /**
     * @var string
     *
     * @ORM\Column(name="ser_name", type="string", length=45, nullable=false)
     */
    private $serName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ser_status", type="boolean", nullable=false)
     */
    private $serStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ser_created_date", type="datetime", nullable=false)
     */
    private $serCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ser_updated_date", type="datetime", nullable=true)
     */
    private $serUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="ser_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $serId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->serCreatedDate = new \DateTime();
        $this->serStatus = 1;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->serUpdatedDate = new \DateTime();
    }

    function getSerName() {
        return $this->serName;
    }

    function getSerStatus() {
        return $this->serStatus;
    }

    function getSerCreatedDate() {
        return $this->serCreatedDate;
    }

    function getSerUpdatedDate() {
        return $this->serUpdatedDate;
    }

    function getSerId() {
        return $this->serId;
    }

    function setSerName($serName) {
        $this->serName = $serName;
    }

    function setSerStatus($serStatus) {
        $this->serStatus = $serStatus;
    }

    function setSerCreatedDate(\DateTime $serCreatedDate) {
        $this->serCreatedDate = $serCreatedDate;
    }

    function setSerUpdatedDate(\DateTime $serUpdatedDate) {
        $this->serUpdatedDate = $serUpdatedDate;
    }

    function setSerId($serId) {
        $this->serId = $serId;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context) {
        if (strlen($this->getSerName()) < 5) {
            $context->buildViolation('Service Name is too short!')
                    ->atPath('serName')
                    ->addViolation();
        }
    }

}
