<?php

namespace spec\App;

use App\Sample;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;
use stdClass;

/*
 * Object itself:
 *   $this implements the "App\Sample" behavior
 */
class SampleSpec extends ObjectBehavior
{
    /**
     * Run before EACH spec
     */
    public function let(SampleSpec $sample)
    {
        // $this is object itself
        $app_sample = new self();   

        $this->beConstructedWith($sample, []); // no args

        // test for object creation
        // $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    /**
     * Run after EACH spec
     */
    public function letGo()
    {
        // cleanup
    }

    /**
     * All tests should begin with "it" or "its"...
     */
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

    // http://www.phpspec.net/en/stable/cookbook/matchers.html
    public function it_have_matchers()
    {
        // identity ===
        $this->sampleText('t')->shouldBe('it is t');
        $this->sampleText('t')->shouldBeEqualTo('it is t');
        $this->sampleText('t')->shouldReturn('it is t');
        $this->sampleText('t')->shouldEqual('it is t');

        // comparison ==
        $this->sampleText('test')->shouldBeLike('it is test');

        // approximate
        // $this->sample(1)->shouldBeApproximately(1.00001, 1.0e-9);

        // throw
        // $this->shouldThrow('\InvalidArgumentException')->duringSampleText('arg');
        // $this->shouldThrow('\InvalidArgumentException')->during('sampleText', ['arg']);
        // $this->shouldTrigger(\E_USER_DEPRECATED, 'The method is deprecated')->duringSampleText('4');

        // type
        $this->shouldHaveType('App\\Sample');
        $this->shouldReturnAnInstanceOf('App\\Sample');
        $this->shouldBeAnInstanceOf('App\\Sample');
        $this->shouldImplement('App\\Sample');

        // Object state matcher is* ou has*
        //      will calls isSample()
        //$this->shouldBeSample();
        //      will calls hasSample()
        //$this->shouldHaveSample();

        // Count matcher (should return \Traversable)
        //$this->sample()->shouldHaveCount(1);

        //scalar
        //$this->sample()->shouldBeString();
        //$this->sample()->shouldBeArray();

        // iterable (\Traversable) that contains with (===)
        // $this->sample()->shouldContain('Jane');
        // $this->sample()->shouldHaveKeyWithValue('leadRole', 'John');
        // $this->sample()->shouldHaveKey('France');

        // same
        // $this->sample()->shouldIterateAs(new \ArrayIterator(['Jane', 'John'])); 
        // $this->sample()->shouldYield(new \ArrayIterator(['Jane', 'John']));

        // with ==
        // $this->sample()->shouldIterateLike(new \ArrayIterator(['Jane Smith', 'John Smith']));
        // $this->sample()->shouldYieldLike(new \ArrayIterator(['Jane Smith', 'John Smith']));

        // with ===
        // $this->sample()->shouldStartIteratingAs(new \ArrayIterator(['Jane Smith']));
        // $this->sample()->shouldStartYielding(new \ArrayIterator(['Jane Smith']));

        // String contains
        // $this->getTitle()->shouldContain('Wizard');
        // $this->getTitle()->shouldStartWith('The Wizard');
        // $this->getTitle()->shouldEndWith('of Oz');
        // $this->getTitle()->shouldMatch('/wizard/i');

        // With custom matchers
        $this->sampleText('y')->shouldSampleCustom('it is y customs');
        // $this->sample()->shouldHaveKey('username');
        // $this->sample()->shouldHaveValue('diegoholiveira');

        /* 
         * If should...method is implemented in object
         */
        //$this->callOnWrappedObject('shouldHandle', array($somethingToHandle));
    }

    // Custom matchers //
    public function getMatchers(): array
    {
        return [
            'sampleCustom' => function($returned, $testedValue) {
                return $testedValue === "$returned customs" ? true : false;
            },
            'haveKey' => function ($subject, $key) {
                if (!array_key_exists($key, $subject)) {
                    throw new FailureException(sprintf(
                        'Message with subject "%s" and key "%s".',
                        $subject, $key
                    ));
                }
                return true;
            },
            'haveValue' => function ($subject, $value) {
                return in_array($value, $subject);
            },
        ];
    }

    /**
     * @see https://github.com/phpspec/prophecy
     * 
     *  doubles without behavior (dummies)
     *  doubles with behavior, but no expectations (stubs)
     */
    public function it_prophecy_usage()
    {
        $prophet = new \Prophecy\Prophet;

        // Stub object
        $dummies = $prophet->prophesize(); //class ObjectProphecy
        $dummies->willExtend('App\Sample');
        $dummies->willImplement('SessionHandlerInterface');

        // Stub methods
        $dummies->sampleText('qwerty')
            ->willReturn('customized return');
            // ->willReturnArgument($index)
            // ->willThrow($exception)
            // ->will($callback)
        $dummies->sampleText('123')->will(
            new \Prophecy\Promise\ReturnPromise(['value'])
            // new \Prophecy\Promise\ReturnPromise(['value'])
            // new \Prophecy\Promise\ThrowPromise(['value']) 
            // new \Prophecy\Promise\CallbackPromise(['value'])
        );

        // define multiple returns...
        $dummies->sampleText('everzet')->will(function ($args) use ($dummies) {
            // $mock->setName()->willReturn('everzet was the arguments');
            // $mock->setName(new \Prophecy\Argument\Token\ExactValueToken('everzet'));
            // $mock->setName(\Prophecy\Argument::exact('everzet'));
            return 'testing ok';
        });

        /*
         * Arguments
        IdenticalValueToken or Argument::is($value)
        ExactValueToken or Argument::exact($value) 
        TypeToken or Argument::type($typeOrClass)
        ObjectStateToken or Argument::which($method, $value) 
        CallbackToken or Argument::that(callback) 
        AnyValueToken or Argument::any() 
        AnyValuesToken or Argument::cetera()
        StringContainsToken or Argument::containingString($value) 
        InArrayToken or Argument::in($array)
        NotInArrayToken or Argument::notIn($array)
         */

        // Reveal
        $stub = $dummies->reveal(); // Become a "real" object
        $stub->sampleText('everzet') == 'testing ok';

        /**
         * Mock object
         */
        $dummies = $prophet->prophesize('App\Sample'); //class ObjectProphecy
        
        $dummies->sampleText('123')->shouldBeCalled();
        $dummies->sampleText('two')->shouldBeCalledTimes(2);

         /*
        CallPrediction or shouldBeCalled()
        NoCallsPrediction or shouldNotBeCalled() 
        CallTimesPrediction or shouldBeCalledTimes($count) 
        CallbackPrediction or should($callback)
        */

        // Reveal
        $mock = $dummies->reveal(); // Become a "real" object
        $mock->sampleText('123');
        $mock->sampleText('two');
        $mock->sampleText('two');

        // Spy
        $dummies->sampleText('two')->shouldHaveBeenCalled();

        // Check
        $prophet->checkPredictions();
    }
}
