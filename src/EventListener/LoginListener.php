<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 15:51
 */

namespace App\EventListener;

use App\Service\DateTimeHandler;
use App\Service\UserEventsHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use App\Entity\User;
use App\Service\LoginEventHandler;

class LoginListener
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the User entity.
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof User)
        {
            // Let handler do its job
            $eventHandler = new LoginEventHandler($user, $this->em, new DateTimeHandler());
            $eventHandler->handleEvent();
        }
    }
}