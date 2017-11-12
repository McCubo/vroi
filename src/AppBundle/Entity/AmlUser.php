<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AmlUser
 *
 * @ORM\Table(name="aml_user", uniqueConstraints={@ORM\UniqueConstraint(name="use_name_UNIQUE", columns={"use_name"}), @ORM\UniqueConstraint(name="use_email_UNIQUE", columns={"use_email"})}, indexes={@ORM\Index(name="FK_user_role", columns={"use_rol_id"}), @ORM\Index(name="FK_user_country", columns={"use_cou_id"}), @ORM\Index(name="FK_user_station", columns={"use_sta_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields= {"useName"}, message="Invalid Username: There is already an user with that name!")
 * @UniqueEntity(fields= {"useEmail"}, message="Invalid Email: The given email is already assigned to another user!")
 */
class AmlUser implements AdvancedUserInterface, \Serializable {

    public function __construct() {
        
    }

    /**
     * @var string
     *
     * @ORM\Column(name="use_name", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
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
     * @var string
     *
     * @ORM\Column(name="use_token", type="string", length=45, nullable=false)
     */
    private $useToken;

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
     * @Assert\NotBlank()
     */
    private $useCou;

    /**
     * @var \AppBundle\Entity\AmlRol
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlRol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="use_rol_id", referencedColumnName="rol_id")
     * })
     * @Assert\NotBlank()
     */
    private $useRol;

    /**
     * @var \AppBundle\Entity\AmlStation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AmlStation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="use_sta_id", referencedColumnName="sta_id")
     * })
     * @Assert\NotBlank()
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

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->useStatus = 1;
    }

    function getUseName() {
        return $this->useName;
    }

    function getUsePassword() {
        return $this->usePassword;
    }

    function getUseStatus() {
        return $this->useStatus;
    }

    function getUseEmail() {
        return $this->useEmail;
    }

    function getUsePhoneNumber() {
        return $this->usePhoneNumber;
    }

    function getUseId() {
        return $this->useId;
    }

    function getUseCou() {
        return $this->useCou;
    }

    function getUseRol() {
        return $this->useRol;
    }

    function getUseSta() {
        return $this->useSta;
    }

    function getUseConfirmationDate() {
        return $this->useConfirmationDate;
    }

    function getUseExpirationDate() {
        return $this->useExpirationDate;
    }

    function setUseName($useName) {
        $this->useName = $useName;
    }

    function setUsePassword($usePassword) {
        $this->usePassword = $usePassword;
    }

    function setUseStatus($useStatus) {
        $this->useStatus = $useStatus;
    }

    function setUseEmail($useEmail) {
        $this->useEmail = $useEmail;
    }

    function setUsePhoneNumber($usePhoneNumber) {
        $this->usePhoneNumber = $usePhoneNumber;
    }

    function setUseId($useId) {
        $this->useId = $useId;
    }

    function setUseCou(\AppBundle\Entity\AmlCountry $useCou) {
        $this->useCou = $useCou;
    }

    function setUseRol(\AppBundle\Entity\AmlRol $useRol) {
        $this->useRol = $useRol;
    }

    function setUseSta(\AppBundle\Entity\AmlStation $useSta) {
        $this->useSta = $useSta;
    }

    function setUseConfirmationDate(\DateTime $useConfirmationDate) {
        $this->useConfirmationDate = $useConfirmationDate;
    }

    function setUseExpirationDate(\DateTime $useExpirationDate) {
        $this->useExpirationDate = $useExpirationDate;
    }

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
        return $this->useName . "(" . $this->useEmail . ")";
    }

    function getUseToken() {
        return $this->useToken;
    }

    function setUseToken($useToken) {
        $this->useToken = $useToken;
    }

}
