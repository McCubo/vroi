<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderEvalScore
 *
 * @ORM\Table(name="aml_provider_eval_score", indexes={@ORM\Index(name="FK_pes_evp", columns={"pes_evp_id"}), @ORM\Index(name="FK_pes_pre", columns={"pes_pre_id"})})
 * @ORM\Entity
 */
class AmlProviderEvalScore {

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
     * @var integer
     *
     * @ORM\Column(name="pes_evp_id", type="integer", nullable=false)
     */
    private $pesEvpId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pes_pre_id", type="integer", nullable=false)
     */
    private $pesPreId;

    function getPesScore() {
        return $this->pesScore;
    }

    function getPesId() {
        return $this->pesId;
    }

    function getPesEvpId() {
        return $this->pesEvpId;
    }

    function getPesPreId() {
        return $this->pesPreId;
    }

    function setPesScore($pesScore) {
        $this->pesScore = $pesScore;
    }

    function setPesId($pesId) {
        $this->pesId = $pesId;
    }

    function setPesEvpId($pesEvpId) {
        $this->pesEvpId = $pesEvpId;
    }

    function setPesPreId($pesPreId) {
        $this->pesPreId = $pesPreId;
    }

}
