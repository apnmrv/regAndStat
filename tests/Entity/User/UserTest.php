<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 02/06/2018
 * Time: 05:03
 */

namespace App\Entity\User;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_construct()
    {

        $u = new User();

        $this->assertInstanceOf(User::class, $u);

    }

    /**
     *
     */
    public function testSetGetUsername()
    {
        $u = new User();
        $u->setUsername('username');
        $this->assertEquals('username', $u->getUsername());

    }

    public function testGetEmail()
    {
        $u = new User();
        $u->setUsername('username');
        $this->assertEquals('username', $u->getUsername());

    }

    public function testGetCountry()
    {

    }

    public function testGetLastName()
    {

    }

    public function testGetSex()
    {

    }

    public function testGetDateOfBirth()
    {

    }

    public function testGetCity()
    {

    }

    public function testSetPlainPassword()
    {

    }

    public function testGetFirstName()
    {

    }

    public function testGetRoles()
    {

    }


}
