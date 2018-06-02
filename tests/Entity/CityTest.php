<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 30/05/2018
 * Time: 13:50
 */

namespace App\Tests\Entity;
use PHPUnit\Framework\TestCase;
use App\Entity\City;


class CityTest extends TestCase
{
    /**
     * @test
     */
    public function happyCreation()
    {
        $city = new City();

        $this->assertInstanceOf(City::class, $city);

    }
}