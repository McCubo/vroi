<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderRelation
 *
 * @ORM\Table(name="aml_provider_relation", indexes={@ORM\Index(name="FK_provider_relation_parent", columns={"prr_parent_pro_id"}), @ORM\Index(name="FK_provider_relation_child", columns={"prr_child_pro_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AmlProviderRelationRepository")
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
     * @var integer
     *
     * @ORM\Column(name="prr_child_pro_id", type="integer", nullable=false)
     */
    private $prrChildProId;

    /**
     * @var integer
     *
     * @ORM\Column(name="prr_parent_pro_id", type="integer", nullable=false)
     */
    private $prrParentProId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->prrCreatedDate = new \DateTime();
    }

    function getPrrCreatedDate() {
        return $this->prrCreatedDate;
    }

    function getPrrId() {
        return $this->prrId;
    }

    function getPrrChildProId() {
        return $this->prrChildProId;
    }

    function getPrrParentProId() {
        return $this->prrParentProId;
    }

    function setPrrCreatedDate(\DateTime $prrCreatedDate) {
        $this->prrCreatedDate = $prrCreatedDate;
    }

    function setPrrId($prrId) {
        $this->prrId = $prrId;
    }

    function setPrrChildProId($prrChildProId) {
        $this->prrChildProId = $prrChildProId;
    }

    function setPrrParentProId($prrParentProId) {
        $this->prrParentProId = $prrParentProId;
    }

}
