<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderEvaluation
 *
 * @ORM\Table(name="aml_provider_evaluation", indexes={@ORM\Index(name="FK_pre_provider", columns={"pre_pro_id"}), @ORM\Index(name="FK_pre_user", columns={"pre_use_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderEvaluation
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pre_date", type="datetime", nullable=false)
     */
    private $preDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="pre_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $preId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pre_pro_id", type="integer", nullable=false)
     */
    private $preProId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pre_use_id", type="integer", nullable=false)
     */
    private $preUseId;

   /**
     * @ORM\PrePersist
     */
    public function setDateValue()
    {
        $this->preDate = new \DateTime();
    }
    function getPreDate() {
        return $this->preDate;
    }

    function getPreId() {
        return $this->preId;
    }

    function getPreProId() {
        return $this->preProId;
    }

    function getPreUseId() {
        return $this->preUseId;
    }

    function setPreDate(\DateTime $preDate) {
        $this->preDate = $preDate;
    }

    function setPreId($preId) {
        $this->preId = $preId;
    }

    function setPreProId($preProId) {
        $this->preProId = $preProId;
    }

    function setPreUseId($preUseId) {
        $this->preUseId = $preUseId;
    }


}
