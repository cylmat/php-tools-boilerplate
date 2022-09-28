<?php

declare(strict_types=1);

namespace App\Tests;

use App\Sample;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testSample(): void
    {
        $this->assertEquals(5, (new Sample())->sample(4));
    }
}
