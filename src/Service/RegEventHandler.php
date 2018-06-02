<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 14:03
 */

namespace App\Service;

use App\Entity\RegistrationEvent;

class RegEventHandler extends UserEventsHandler
{
    public function handleEvent()
    {
        $this->event = new RegistrationEvent($this->user,
            $this->dateTimeHandler->getDateObjectFromString($this->date));
        $this->persistEvent();
    }
}