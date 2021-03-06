<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * AmlStation
 *
 * @ORM\Table(name="aml_station", uniqueConstraints={@ORM\UniqueConstraint(name="sta_name_UNIQUE", columns={"sta_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields= {"staName"}, message="There is already a Station with that name!")
 */
class AmlStation {

    /**
     * @var string
     *
     * @ORM\Column(name="sta_name", type="string", length=45, nullable=false)
     */
    private $staName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sta_created_date", type="datetime", nullable=false)
     */
    private $staCreatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="sta_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $staId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->staCreatedDate = new \DateTime();
    }

    function getStaName() {
        return $this->staName;
    }

    function getStaCreatedDate() {
        return $this->staCreatedDate;
    }

    function getStaId() {
        return $this->staId;
    }

    function setStaName($staName) {
        $this->staName = $staName;
    }

    function setStaCreatedDate(\DateTime $staCreatedDate) {
        $this->staCreatedDate = $staCreatedDate;
    }

    function setStaId($staId) {
        $this->staId = $staId;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context) {
        if (strlen($this->getStaName()) < 4) {
            $context->buildViolation('Station Name is too short!')
                    ->atPath('staName')
                    ->addViolation();
        }
    }

    public function __toString() {
        return $this->staName;
    }

}
