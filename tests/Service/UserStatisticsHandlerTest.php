<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 21:08
 */

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class UserStatisticsHandlerTest extends TestCase
{
    public function test__construct()
    {
        $objectManager = $this->createMock(ObjectManager::class);

        $handler = new UserStatisticsHandler($objectManager);
        $this->assertAttributeInstanceOf(ObjectManager::class, 'entityManager', $handler);
    }

    public function testGetVisits()
    {

    }

    public function testGetVisitors()
    {

    }

    public function testGetRegistrations()
    {

    }

    /**
     *
     */
    public function testGetBirthdays()
    {

    }
}
