<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlProviderType
 *
 * @ORM\Table(name="aml_provider_type", uniqueConstraints={@ORM\UniqueConstraint(name="prt_name_UNIQUE", columns={"prt_name"})})
 * @ORM\Entity
 */
class AmlProviderType
{
    /**
     * @var string
     *
     * @ORM\Column(name="prt_name", type="string", length=45, nullable=false)
     */
    private $prtName;

    /**
     * @var string
     *
     * @ORM\Column(name="prt_description", type="string", length=100, nullable=false)
     */
    private $prtDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prt_status", type="boolean", nullable=false)
     */
    private $prtStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prt_created_date", type="datetime", nullable=false)
     */
    private $prtCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prt_updated_date", type="datetime", nullable=true)
     */
    private $prtUpdatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="prt_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prtId;


}
