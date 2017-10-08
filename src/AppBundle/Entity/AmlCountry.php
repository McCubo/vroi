<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlCountry
 *
 * @ORM\Table(name="aml_country", uniqueConstraints={@ORM\UniqueConstraint(name="cou_name_UNIQUE", columns={"cou_name"})})
 * @ORM\Entity
 */
class AmlCountry
{
    /**
     * @var string
     *
     * @ORM\Column(name="cou_name", type="string", length=100, nullable=false)
     */
    private $couName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cou_created_date", type="datetime", nullable=false)
     */
    private $couCreatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="cou_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $couId;


}
