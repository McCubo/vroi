<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderService
 *
 * @ORM\Table(name="aml_provider_service", indexes={@ORM\Index(name="FK_provider_service", columns={"prs_ser_id"}), @ORM\Index(name="FK_provider_provider", columns={"prs_pro_id"})})
 * @ORM\Entity
 */
class AmlProviderService
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="prs_status", type="boolean", nullable=false)
     */
    private $prsStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prs_created_date", type="datetime", nullable=false)
     */
    private $prsCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prs_updated_date", type="datetime", nullable=true)
     */
    private $prsUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="prs_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prsId;

    /**
     * @var \AppBundle\Entity\AmlProvider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProvider")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prs_pro_id", referencedColumnName="pro_id")
     * })
     */
    private $prsPro;

    /**
     * @var \AppBundle\Entity\AmlService
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlService")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prs_ser_id", referencedColumnName="ser_id")
     * })
     */
    private $prsSer;


}
