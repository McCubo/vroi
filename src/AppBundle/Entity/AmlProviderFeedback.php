<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderFeedback
 *
 * @ORM\Table(name="aml_provider_feedback", indexes={@ORM\Index(name="FK_prf_pro_id", columns={"prf_pro_id"}), @ORM\Index(name="FK_prf_use_id", columns={"prf_use_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderFeedback
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prf_date", type="datetime", nullable=false)
     */
    private $prfDate;

    /**
     * @var string
     *
     * @ORM\Column(name="prf_comment", type="text", nullable=false)
     */
    private $prfComment;

    /**
     * @var integer
     *
     * @ORM\Column(name="prf_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prfId;

    /**
     * @var \AppBundle\Entity\AmlProvider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProvider")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prf_pro_id", referencedColumnName="pro_id")
     * })
     */
    private $prfPro;

    /**
     * @var \AppBundle\Entity\AmlUser
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prf_use_id", referencedColumnName="use_id")
     * })
     */
    private $prfUse;

   /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->prfDate = new \DateTime();
    }
}
