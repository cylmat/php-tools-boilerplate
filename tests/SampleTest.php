<?php

namespace App\Tests;

use App\Sample;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function testSample(): void
    {
        $sample = new Sample();
        $this->assertEquals(5, $sample->sample(4));
    }
}
