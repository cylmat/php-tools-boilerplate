<?php

namespace App\Tests;

use App\Sample;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Sample
 */
class SampleTest extends TestCase
{
    public function setUp(): void
    {
    }

    /**
     * @todo assertions
     * https://phpunit.readthedocs.io/en/9.5/assertions.html
     * @todo annotations
     * https://phpunit.readthedocs.io/en/9.5/annotations.html
     *
     * @group in
     */
    public function testSample(): void
    {
        $sample = new Sample();
        $this->assertEquals(5, $sample->sample(4));
    }
}
