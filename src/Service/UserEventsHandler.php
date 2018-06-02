<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 13:58
 */

namespace App\Service;


abstract class UserEventHandler
{
    protected $user;

    protected $date;

    protected $time;

    abstract public function handleRegistrationEvent();

    abstract public function handleLoginEvent();
}