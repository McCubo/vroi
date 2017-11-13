<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderFeedback
 *
 * @ORM\Table(name="aml_provider_feedback", indexes={@ORM\Index(name="FK_prf_pro_id", columns={"prf_pro_id"}), @ORM\Index(name="FK_prf_use_id", columns={"prf_use_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AmlProviderFeedbackRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class AmlProviderFeedback {

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
     * @var integer
     *
     * @ORM\Column(name="prf_pro_id", type="integer", nullable=false)
     */
    private $prfProId;

    /**
     * @var integer
     *
     * @ORM\Column(name="prf_use_id", type="integer", nullable=false)
     */
    private $prfUseId;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->prfDate = new \DateTime();
    }

    function getPrfComment() {
        return $this->prfComment;
    }

    function getPrfId() {
        return $this->prfId;
    }

    function getPrfProId() {
        return $this->prfProId;
    }

    function getPrfUseId() {
        return $this->prfUseId;
    }

    function setPrfComment($prfComment) {
        $this->prfComment = $prfComment;
    }

    function setPrfId($prfId) {
        $this->prfId = $prfId;
    }

    function setPrfProId($prfProId) {
        $this->prfProId = $prfProId;
    }

    function setPrfUseId($prfUseId) {
        $this->prfUseId = $prfUseId;
    }

    function getPrfDate() {
        return $this->prfDate;
    }

    function setPrfDate(\DateTime $prfDate) {
        $this->prfDate = $prfDate;
    }

}
