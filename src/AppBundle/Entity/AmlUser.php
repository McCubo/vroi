<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * AmlUser
 *
 * @ORM\Table(name="aml_user", uniqueConstraints={@ORM\UniqueConstraint(name="use_name_UNIQUE", columns={"use_name"}), @ORM\UniqueConstraint(name="use_email_UNIQUE", columns={"use_email"})}, indexes={@ORM\Index(name="FK_user_role", columns={"use_rol_id"}), @ORM\Index(name="FK_user_country", columns={"use_cou_id"}), @ORM\Index(name="FK_user_station", columns={"use_sta_id"})})
 * @ORM\Entity
 */
class AmlUser implements AdvancedUserInterface, \Serializable {

    public function __construct() {
        
    }

    /**
     * @var string
     *
     * @ORM\Column(name="use_name", type="string", length=45, nullable=false)
     */
    private $useName;

    /**
     * @var string
     *
     * @ORM\Column(name="use_password", type="string", length=150, nullable=false)
     */
    private $usePassword;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_status", type="boolean", nullable=false)
     */
    private $useStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="use_email", type="string", length=150, nullable=false)
     */
    private $useEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="use_phone_number", type="string", length=45, nullable=true)
     */
    private $usePhoneNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="use_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $useId;

    /**
     * @var \AppBundle\Entity\AmlCountry
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlCountry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="use_cou_id", referencedColumnName="cou_id")
     * })
     */
    private $useCou;

    /**
     * @var \AppBundle\Entity\AmlRol
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlRol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="use_rol_id", referencedColumnName="rol_id")
     * })
     */
    private $useRol;

    /**
     * @var \AppBundle\Entity\AmlStation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlStation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="use_sta_id", referencedColumnName="sta_id")
     * })
     */
    private $useSta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="use_confirmation_date", type="datetime", nullable=true)
     */
    private $useConfirmationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="use_expiration_date", type="datetime", nullable=true)
     */
    private $useExpirationDate;

    public function eraseCredentials() {
        
    }

    public function getPassword() {
        return $this->usePassword;
    }

    public function getRoles() {
        return array($this->useRol->getRoleName());
    }

    public function getSalt() {
        return null;
    }

    public function getUsername() {
        return $this->useName;
    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->useId,
            $this->useName,
            $this->usePassword,
            $this->useStatus
        ));
    }

    public function unserialize($serialized) {
        list (
                $this->useId,
                $this->useName,
                $this->usePassword,
                $this->useStatus
                ) = unserialize($serialized);
    }

    //  checks whether the user's account has expired
    public function isAccountNonExpired() {
        return $this->useExpirationDate == null;
    }

    //  checks whether the user is locked;
    public function isAccountNonLocked() {
        return $this->useConfirmationDate != null;
    }

    //  checks whether the user's credentials has expired;
    public function isCredentialsNonExpired() {
        return true;
    }

    //  checks whether the user is enabled.
    public function isEnabled() {
        return $this->useStatus;
    }

    public function getPrintValue() {
        return $this->useEmail . "(" . $this->useName . ")";
    }

}
