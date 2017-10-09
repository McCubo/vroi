<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmlStation
 *
 * @ORM\Table(name="aml_station", uniqueConstraints={@ORM\UniqueConstraint(name="sta_name_UNIQUE", columns={"sta_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AmlStation
{
    /**
     * @var string
     *
     * @ORM\Column(name="sta_name", type="string", length=45, nullable=false)
     */
    private $staName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sta_created_date", type="datetime", nullable=false)
     */
    private $staCreatedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="sta_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $staId;

   /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->staCreatedDate = new \DateTime();
    }
}
