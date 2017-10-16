<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * AmlProviderGroup
 *
 * @ORM\Table(name="aml_provider_group", uniqueConstraints={@ORM\UniqueConstraint(name="prg_name_UNIQUE", columns={"prg_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields= {"prgName"}, message="Invalid Provider Group Name: There is already a Provider Group with that name!")
 */
class AmlProviderGroup {

    /**
     * @var string
     *
     * @ORM\Column(name="prg_name", type="string", length=45, nullable=false)
     */
    private $prgName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prg_status", type="boolean", nullable=false)
     */
    private $prgStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prg_created_at", type="datetime", nullable=false)
     */
    private $prgCreatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prg_updated_at", type="datetime", nullable=true)
     */
    private $prgUpdatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="prg_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prgId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->prgCreatedAt = new \DateTime();
        $this->prgStatus = 1;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->prgUpdatedAt = new \DateTime();
    }

    function getPrgName() {
        return $this->prgName;
    }

    function getPrgStatus() {
        return $this->prgStatus;
    }

    function getPrgCreatedAt() {
        return $this->prgCreatedAt;
    }

    function getPrgUpdatedAt() {
        return $this->prgUpdatedAt;
    }

    function getPrgId() {
        return $this->prgId;
    }

    function setPrgName($prgName) {
        $this->prgName = $prgName;
    }

    function setPrgStatus($prgStatus) {
        $this->prgStatus = $prgStatus;
    }

    function setPrgCreatedAt(\DateTime $prgCreatedAt) {
        $this->prgCreatedAt = $prgCreatedAt;
    }

    function setPrgUpdatedAt(\DateTime $prgUpdatedAt) {
        $this->prgUpdatedAt = $prgUpdatedAt;
    }

    function setPrgId($prgId) {
        $this->prgId = $prgId;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context) {
        if (strlen($this->getPrgName()) < 5) {
            $context->buildViolation('Provider Group name is too short!')
                    ->atPath('prgName')
                    ->addViolation();
        }
    }

}
