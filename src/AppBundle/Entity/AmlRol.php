<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlRol
 *
 * @ORM\Table(name="aml_rol", uniqueConstraints={@ORM\UniqueConstraint(name="rol_name_UNIQUE", columns={"rol_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlRol {

    /**
     * @var string
     *
     * @ORM\Column(name="rol_name", type="string", length=20, nullable=false)
     */
    private $rolName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rol_status", type="boolean", nullable=false)
     */
    private $rolStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rol_created_date", type="datetime", nullable=false)
     */
    private $rolCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rol_updated_date", type="datetime", nullable=true)
     */
    private $rolUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="rol_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rolId;

    public function getRoleName() {
        return $this->rolName;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->rolCreatedDate = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->rolUpdatedDate = new \DateTime();
    }
    public function __toString() {
        return $this->rolName;
    }
}
