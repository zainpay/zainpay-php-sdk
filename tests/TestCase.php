<?php

namespace Zainpay\SDK\Tests;

use Faker\Factory;
use Faker\Generator;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Generator $faker;


    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }
}