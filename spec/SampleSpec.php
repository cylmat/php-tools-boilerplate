<?php

namespace spec\App;

use App\Sample;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;
use stdClass;

/*
 * Object itself:
 * $this implements the "namespace\class" behavior
 */
class SampleSpec extends ObjectBehavior
{
    /**
     * Run before EACH spec
     */
    public function let(SampleSpec $sample)
    {
        $this->beConstructedWith($sample);
    }

    /**
     * Run after EACH spec
     */
    public function letGo()
    {
        // cleanup
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Sample::class);
    }

    /**
     * Use typehint or beADoubleOf()
     */
    public function it_stubs_and_mocks(SampleSpec $notImplementedStub, $notImplementedMock)
    {
        // Stub "SampleSpec"
        $notImplementedStub->my_method()->willReturn('hello');
        $this->sampleObject($notImplementedStub);

        // Mock "SampleSpec"
        $notImplementedMock->beADoubleOf('spec\App\SampleSpec');
        $notImplementedMock->my_method('here')->shouldBeCalled();
        $this->sampleObject($notImplementedMock, 'here');

        // Spie after
        $notImplementedMock->my_method('here')->shouldHaveBeenCalled();
    }

    /**
     * Used for it_stubs_and_mocks()
     */
    public function my_method(string $text): string
    {
        return 'modified ' . $text;
    }

    public function it_describes_the_methods_behaviors()
    {
        $this->sampleText("there")->shouldReturn("it is there");
    }

    public function it_skips_behaviors()
    {
        if (!function_exists('strrev')) {
            throw new SkippingException(
                'The strrev function is unavailable'
            );
        }
    }
}
