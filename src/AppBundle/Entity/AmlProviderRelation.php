<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderRelation
 *
 * @ORM\Table(name="aml_provider_relation", indexes={@ORM\Index(name="FK_provider_relation_parent", columns={"prr_parent_pro_id"}), @ORM\Index(name="FK_provider_relation_child", columns={"prr_child_pro_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderRelation {

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prr_created_date", type="datetime", nullable=false)
     */
    private $prrCreatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="prr_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prrId;

    /**
     * @var \AppBundle\Entity\AmlProvider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProvider")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prr_child_pro_id", referencedColumnName="pro_id")
     * })
     */
    private $prrChildPro;

    /**
     * @var \AppBundle\Entity\AmlProvider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProvider")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prr_parent_pro_id", referencedColumnName="pro_id")
     * })
     */
    private $prrParentPro;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->prrCreatedDate = new \DateTime();
    }

}
