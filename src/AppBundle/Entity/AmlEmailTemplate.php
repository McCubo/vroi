<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * AmlEmailTemplate
 *
 * @ORM\Table(name="aml_email_template", uniqueConstraints={@ORM\UniqueConstraint(name="ema_name_UNIQUE", columns={"ema_name"})})
 * @ORM\Entity
 * @UniqueEntity(fields= {"emaName"}, message="There is already a Configured Template with that name!")
 */
class AmlEmailTemplate {

    /**
     * @var string
     *
     * @ORM\Column(name="ema_body", type="text", nullable=false)
     */
    private $emaBody;

    /**
     * @var string
     *
     * @ORM\Column(name="ema_name", type="string", length=50, nullable=false)
     */
    private $emaName;

    /**
     * @var integer
     *
     * @ORM\Column(name="ema_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $emaId;

    function getEmaBody() {
        return $this->emaBody;
    }

    function getEmaName() {
        return $this->emaName;
    }

    function getEmaId() {
        return $this->emaId;
    }

    function setEmaBody($emaBody) {
        $this->emaBody = $emaBody;
    }

    function setEmaName($emaName) {
        $this->emaName = $emaName;
    }

    function setEmaId($emaId) {
        $this->emaId = $emaId;
    }

}
