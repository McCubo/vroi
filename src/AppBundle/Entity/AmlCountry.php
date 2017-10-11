<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlCountry
 *
 * @ORM\Table(name="aml_country", uniqueConstraints={@ORM\UniqueConstraint(name="cou_name_UNIQUE", columns={"cou_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlCountry {

    /**
     * @var string
     *
     * @ORM\Column(name="cou_name", type="string", length=100, nullable=false)
     */
    private $couName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cou_created_date", type="datetime", nullable=false)
     */
    private $couCreatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="cou_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $couId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->couCreatedDate = new \DateTime();
    }

    function getCouName() {
        return $this->couName;
    }

    function getCouCreatedDate() {
        return $this->couCreatedDate;
    }

    function getCouId() {
        return $this->couId;
    }

    function setCouName($couName) {
        $this->couName = $couName;
    }

    function setCouCreatedDate(\DateTime $couCreatedDate) {
        $this->couCreatedDate = $couCreatedDate;
    }

    function setCouId($couId) {
        $this->couId = $couId;
    }

    public function __toString() {
        return $this->couName;
    }

}
