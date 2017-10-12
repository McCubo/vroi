<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * AmlProviderType
 *
 * @ORM\Table(name="aml_provider_type", uniqueConstraints={@ORM\UniqueConstraint(name="prt_name_UNIQUE", columns={"prt_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderType {

    /**
     * @var string
     *
     * @ORM\Column(name="prt_name", type="string", length=45, nullable=false)
     * @Assert\NotBlank
     */
    private $prtName;

    /**
     * @var string
     *
     * @ORM\Column(name="prt_description", type="string", length=100, nullable=false)
     * @Assert\NotBlank
     */
    private $prtDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prt_status", type="boolean", nullable=false)
     */
    private $prtStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prt_created_date", type="datetime", nullable=false)
     */
    private $prtCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prt_updated_date", type="datetime", nullable=true)
     */
    private $prtUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="prt_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prtId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->prtCreatedDate = new \DateTime();
        $this->prtStatus = 1;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->prtUpdatedDate = new \DateTime();
    }

    function getPrtName() {
        return $this->prtName;
    }

    function getPrtDescription() {
        return $this->prtDescription;
    }

    function setPrtName($prtName) {
        $this->prtName = $prtName;
    }

    function setPrtDescription($prtDescription) {
        $this->prtDescription = $prtDescription;
    }

    function getPrtId() {
        return $this->prtId;
    }

    function getPrtStatus() {
        return $this->prtStatus;
    }

    function getPrtCreatedDate() {
        return $this->prtCreatedDate;
    }

    function getPrtUpdatedDate() {
        return $this->prtUpdatedDate;
    }

    function setPrtStatus($prtStatus) {
        $this->prtStatus = $prtStatus;
    }

    function setPrtCreatedDate(\DateTime $prtCreatedDate) {
        $this->prtCreatedDate = $prtCreatedDate;
    }

    function setPrtUpdatedDate(\DateTime $prtUpdatedDate) {
        $this->prtUpdatedDate = $prtUpdatedDate;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context) {
        $fakeNames = array('test', 'Shared service unit');
        if (in_array($this->getPrtName(), $fakeNames) && $this->getPrtId() != 2) {
            $context->buildViolation('This name sounds totally fake!')
                    ->addViolation();
        }
    }

}
