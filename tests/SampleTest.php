<?php

namespace App\Tests;

use App;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function testSample()
    {
        $sample = new Sample();
        $this->assertEqual(5, $sample->sample(4));
    }
}
