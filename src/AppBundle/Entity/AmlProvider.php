<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProvider
 *
 * @ORM\Table(name="aml_provider", uniqueConstraints={@ORM\UniqueConstraint(name="pro_name_UNIQUE", columns={"pro_name"})}, indexes={@ORM\Index(name="FK_provider_afiliation", columns={"pro_pra_id"}), @ORM\Index(name="FK_provider_group", columns={"pro_prg_id"}), @ORM\Index(name="FK_provider_type", columns={"pro_prt_id"})})
 * @ORM\Entity
 */
class AmlProvider
{
    /**
     * @var string
     *
     * @ORM\Column(name="pro_name", type="string", length=45, nullable=false)
     */
    private $proName;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_address", type="string", length=250, nullable=false)
     */
    private $proAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_cit_id", type="integer", nullable=false)
     */
    private $proCitId;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_main_phone_number", type="string", length=45, nullable=false)
     */
    private $proMainPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_site_url", type="string", length=200, nullable=true)
     */
    private $proSiteUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_description", type="string", length=250, nullable=true)
     */
    private $proDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pro_status", type="boolean", nullable=false)
     */
    private $proStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pro_created_date", type="datetime", nullable=false)
     */
    private $proCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pro_updated_date", type="datetime", nullable=true)
     */
    private $proUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proId;

    /**
     * @var \AppBundle\Entity\AmlProviderAfiliation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProviderAfiliation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pro_pra_id", referencedColumnName="pra_id")
     * })
     */
    private $proPra;

    /**
     * @var \AppBundle\Entity\AmlProviderGroup
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProviderGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pro_prg_id", referencedColumnName="prg_id")
     * })
     */
    private $proPrg;

    /**
     * @var \AppBundle\Entity\AmlProviderType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlProviderType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pro_prt_id", referencedColumnName="prt_id")
     * })
     */
    private $proPrt;


}
