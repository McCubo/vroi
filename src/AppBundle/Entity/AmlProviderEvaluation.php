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
     * @var \AppBundle\Entity\AmlProvider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProvider")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pre_pro_id", referencedColumnName="pro_id")
     * })
     */
    private $prePro;

    /**
     * @var \AppBundle\Entity\AmlUser
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pre_use_id", referencedColumnName="use_id")
     * })
     */
    private $preUse;

   /**
     * @ORM\PrePersist
     */
    public function setDateValue()
    {
        $this->preDate = new \DateTime();
    }

}
