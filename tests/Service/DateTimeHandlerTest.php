<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 19:47
 */

namespace App\Tests\Service;

use App\Service\DateTimeHandler;
use DateTime;
use PHPUnit\Framework\TestCase;
use DateInterval;

class DateTimeHandlerTest extends TestCase
{
    public function test__construct()
    {
        $this->assertNotNull(new DateTimeHandler());
        $this->assertInstanceOf(DateTimeHandler::class, new DateTimeHandler());
    }

    public function testGetDateThisMonthBegan()
    {
        $handler = new DateTimeHandler();
        $this->assertTrue(is_string($handler->getDateThisMonthBegan()));
        $this->assertEquals((new DateTime('now'))->format('Y-m-01'), $handler->getDateThisMonthBegan());

    }

    public function testGetThisMondayDate()
    {
        $handler = new DateTimeHandler();
        $this->assertTrue(is_string($handler->getThisMondayDate()));
        $this->assertEquals((new DateTime('Last Monday'))->format('Y-m-d'), $handler->getThisMondayDate());

    }

    public function testGetDateNow()
    {
        $handler = new DateTimeHandler();
        $this->assertTrue(is_string($handler->getDateNow()));
        $this->assertEquals((new DateTime('now'))->format('Y-m-d'), $handler->getDateNow());
    }

    public function testGetDateSomeDaysFromNow()
    {
        $handler = new DateTimeHandler();
        $this->assertTrue(is_string($handler->getDateSomeDaysFromNow(-3)));
        $this->assertEquals((new DateTime('now'))->sub(new DateInterval('P3D'))->format('Y-m-d'), $handler->getDateSomeDaysFromNow(-3));
        $this->assertEquals((new DateTime('now'))->add(new DateInterval('P150D'))->format('Y-m-d'), $handler->getDateSomeDaysFromNow(150));
    }
}