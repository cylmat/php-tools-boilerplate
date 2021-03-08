<?php

namespace spec\App;

use App\Sample;
use PhpSpec\ObjectBehavior;

class SampleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Sample::class);
    }
}
