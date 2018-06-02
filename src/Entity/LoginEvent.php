<?php

namespace App\Entity;

use DateTime;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoginEventRepository")
 */
class LoginEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="loginEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $loginDate;

    /**
     * @ORM\Column(type="time", nullable=false)
     */
    private $loginTime;

    /**
     * LoginEvent constructor.
     * @param $user
     * @param $loginDate
     * @param $loginTime
     */
    public function __construct(User $user, DateTime $loginDate, DateTime $loginTime)
    {
        $this->user = $user;
        $this->loginDate = $loginDate;
        $this->loginTime = $loginTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLoginDate(): ?DateTime
    {
        return $this->loginDate;
    }

    public function setLoginDate(DateTime $loginDate): self
    {
        $this->loginDate = $loginDate;

        return $this;
    }

    public function getLoginTime(): ?DateTime
    {
        return $this->loginTime;
    }

    public function setLoginTime(DateTime $loginTime): self
    {
        $this->loginTime = $loginTime;

        return $this;
    }
}
