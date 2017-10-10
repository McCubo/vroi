<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlEvaluationPoint
 *
 * @ORM\Table(name="aml_evaluation_point", uniqueConstraints={@ORM\UniqueConstraint(name="evp_name_UNIQUE", columns={"evp_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlEvaluationPoint
{
    /**
     * @var string
     *
     * @ORM\Column(name="evp_name", type="string", length=45, nullable=false)
     */
    private $evpName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="evp_status", type="boolean", nullable=false)
     */
    private $evpStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="evp_created_date", type="datetime", nullable=false)
     */
    private $evpCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="evp_updated_date", type="datetime", nullable=true)
     */
    private $evpUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="evp_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $evpId;

   /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->evpCreatedDate = new \DateTime();
    }

   /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->evpUpdatedDate = new \DateTime();
    }

}
