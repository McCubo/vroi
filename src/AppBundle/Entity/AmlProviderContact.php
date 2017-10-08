<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderContact
 *
 * @ORM\Table(name="aml_provider_contact", indexes={@ORM\Index(name="FK_provider_contact_provider", columns={"prc_pro_id"})})
 * @ORM\Entity
 */
class AmlProviderContact
{
    /**
     * @var string
     *
     * @ORM\Column(name="prc_name", type="string", length=75, nullable=false)
     */
    private $prcName;

    /**
     * @var string
     *
     * @ORM\Column(name="prc_phone_number", type="string", length=25, nullable=false)
     */
    private $prcPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="prc_job_title", type="string", length=50, nullable=false)
     */
    private $prcJobTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="prc_email", type="string", length=175, nullable=false)
     */
    private $prcEmail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prc_created_date", type="datetime", nullable=false)
     */
    private $prcCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prc_updated_date", type="datetime", nullable=true)
     */
    private $prcUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="prc_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prcId;

    /**
     * @var \AppBundle\Entity\AmlProvider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProvider")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prc_pro_id", referencedColumnName="pro_id")
     * })
     */
    private $prcPro;


}
