<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderEvalScore
 *
 * @ORM\Table(name="aml_provider_eval_score", indexes={@ORM\Index(name="FK_pes_evp", columns={"pes_evp_id"}), @ORM\Index(name="FK_pes_pre", columns={"pes_pre_id"})})
 * @ORM\Entity
 */
class AmlProviderEvalScore
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pes_score", type="integer", nullable=false)
     */
    private $pesScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="pes_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pesId;

    /**
     * @var \AppBundle\Entity\AmlEvaluationPoint
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlEvaluationPoint")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pes_evp_id", referencedColumnName="evp_id")
     * })
     */
    private $pesEvp;

    /**
     * @var \AppBundle\Entity\AmlProviderEvaluation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProviderEvaluation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pes_pre_id", referencedColumnName="pre_id")
     * })
     */
    private $pesPre;


}
