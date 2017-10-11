<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlCity
 *
 * @ORM\Table(name="aml_city", indexes={@ORM\Index(name="fk_aml_city_cou_idx", columns={"cit_cou_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
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

}
