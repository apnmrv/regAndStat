<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 30/05/2018
 * Time: 12:44
 */

namespace App\Tests\Entity\Country;

use App\Entity\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    /**
     * @test
     */
    public function happyCreation()
    {
        $country = new Country();

        $this->assertInstanceOf(Country::class, $country);
    }
}
