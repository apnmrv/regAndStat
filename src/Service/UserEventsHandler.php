<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 13:58
 */

namespace App\Service;

use DateTime;
use Doctrine\ORM\EntityManager;
use App\Entity\User;
use Exception;

abstract class UserEventsHandler
{
    protected $user;

    protected $date;

    protected $time;

    protected $entityManager;

    protected $event;

    protected $dateTimeHandler;

    /**
     * UserEventsHandler constructor.
     * @param User $user
     * @param EntityManager $em
     *
     * @param DateTimeHandler $dateTimeHandler
     */
    public function __construct(User $user, EntityManager $em, DateTimeHandler $dateTimeHandler)
    {
        $this->user = $user;
        $this->entityManager = $em;
        $this->dateTimeHandler = $dateTimeHandler;

        $this->date = $this->dateTimeHandler->getDateNow();
        $this->time = $this->dateTimeHandler->getTimeNow();
    }

    protected function persistEvent()
    {
        $this->entityManager->persist($this->event);
        $this->entityManager->flush();
    }

    abstract public function handleEvent();
}