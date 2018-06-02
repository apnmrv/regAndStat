<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 14:07
 */

namespace App\Service;

use App\Entity\LoginEvent;

class LoginEventHandler extends UserEventsHandler
{
    /**
     * Creates Login event and persist it
     */
    public function handleEvent() : void
    {
        $this->event = new LoginEvent($this->user,
            $this->dateTimeHandler->getDateObjectFromString($this->date),
            $this->dateTimeHandler->getDateObjectFromString($this->time));
        $this->persistEvent();
    }
}