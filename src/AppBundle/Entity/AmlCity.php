<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * AmlCity
 *
 * @ORM\Table(name="aml_city", uniqueConstraints={@ORM\UniqueConstraint(name="unique_citname_couid", columns={"cit_cou_id", "cit_name"})}, indexes={@ORM\Index(name="fk_aml_city_cou_idx", columns={"cit_cou_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields= {"citName", "citCou"}, message="There is already a Configured City with that Name for the selected Country")
 */
class AmlCity {

    /**
     * @var string
     *
     * @ORM\Column(name="cit_name", type="string", length=75, nullable=false)
     */
    private $citName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cit_created_date", type="datetime", nullable=false)
     */
    private $citCreatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="cit_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $citId;

    /**
     * @var \AppBundle\Entity\AmlCountry
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlCountry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cit_cou_id", referencedColumnName="cou_id")
     * })
     * @Assert\NotBlank()
     */
    private $citCou;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->citCreatedDate = new \DateTime();
    }

    function getCitName() {
        return $this->citName;
    }

    function getCitCreatedDate() {
        return $this->citCreatedDate;
    }

    function getCitId() {
        return $this->citId;
    }

    function getCitCou() {
        return $this->citCou;
    }

    function setCitName($citName) {
        $this->citName = $citName;
    }

    function setCitCreatedDate(\DateTime $citCreatedDate) {
        $this->citCreatedDate = $citCreatedDate;
    }

    function setCitId($citId) {
        $this->citId = $citId;
    }

    function setCitCou(\AppBundle\Entity\AmlCountry $citCou) {
        $this->citCou = $citCou;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context) {
        if (strlen($this->getCitName()) < 4) {
            $context->buildViolation('City name is too short!')
                    ->atPath('citName')
                    ->addViolation();
        }
    }

    function getCountryName() {
        return $this->citCou->getCouName();
    }

}
