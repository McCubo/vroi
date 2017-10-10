<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderGroup
 *
 * @ORM\Table(name="aml_provider_group", uniqueConstraints={@ORM\UniqueConstraint(name="prg_name_UNIQUE", columns={"prg_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderGroup
{
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
    public function setCreatedAtValue()
    {
        $this->prgCreatedAt = new \DateTime();
    }

   /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->prgUpdatedAt = new \DateTime();
    }
}
