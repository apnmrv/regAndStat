<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique = true)
     *
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=254, unique = true, nullable = false)
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     *
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, nullable = false)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=254, nullable = false)
     *
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable = false)
     *
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable = false)
     *
     */
    private $sex;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $country;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RegistrationEvent", mappedBy="user", cascade={"persist", "remove"})
     */
    private $registrationEvent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LoginEvent", mappedBy="user", orphanRemoval=true)
     */
    private $loginEvents;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = array('ROLE_USER');
        $this->loginEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getRegistrationEvent(): ?RegistrationEvent
    {
        return $this->registrationEvent;
    }

    public function setRegistrationEvent(RegistrationEvent $registrationEvent): self
    {
        $this->registrationEvent = $registrationEvent;

        // set the owning side of the relation if necessary
        if ($this !== $registrationEvent->getUser()) {
            $registrationEvent->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|LoginEvent[]
     */
    public function getLoginEvents(): Collection
    {
        return $this->loginEvents;
    }

    public function addLoginEvent(LoginEvent $loginEvent): self
    {
        if (!$this->loginEvents->contains($loginEvent)) {
            $this->loginEvents[] = $loginEvent;
            $loginEvent->setUser($this);
        }

        return $this;
    }

    public function removeLoginEvent(LoginEvent $loginEvent): self
    {
        if ($this->loginEvents->contains($loginEvent)) {
            $this->loginEvents->removeElement($loginEvent);
            // set the owning side to null (unless already changed)
            if ($loginEvent->getUser() === $this) {
                $loginEvent->setUser(null);
            }
        }

        return $this;
    }
}
