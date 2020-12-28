<?php

namespace App\Tests\Command;

use App\Helper\CityHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CityHelperTest extends KernelTestCase
{
    /**
     * @var CityHelper
     */
    private $cityHelper;

    protected function setUp()
    {
        self::bootKernel();
        $this->cityHelper = self::$container->get('App\Helper\CityHelper');
    }

    /**
     *
     */
    public function testGetCitiesFromMusementAPI()
    {
        $result = $this->cityHelper->getCitiesLatLong(10);
        $this->assertCount(10, $result);

        $result = $this->cityHelper->getCitiesLatLong(5);
        $this->assertCount(5, $result);
    }
}