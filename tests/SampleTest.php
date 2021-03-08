<?php

declare(strict_types=1);

namespace App\Tests;

use App\Sample;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \App\Sample
 */
class SampleTest extends TestCase
{
    /**
     * @var int
     *
     * Used for assertClassHasAttribute
     */
    private $attr;

    /**
     * @var int
     *
     * Used for assertClassHasStaticAttribute
     */
    private static $sAttr;

    /**
     * @before (before EACH tests)
     * @coversNothing
     * @doesNotPerformAssertions
     */
    public function setUp(): void
    {
    }

    /**
     * @afterClass (after all tests done)
     * Used for assertObjectEquals.
     */
    public function myEqual(self $other): bool
    {
        if (__CLASS__ === get_class($other)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     *
     * @runInSeparateProcess (! failed with -Pest-)
     */
    public function dataProviderSample(): array
    {
        // yield ['arg1', 'arg2'];
        return [
            ['arg3', 'arg4'],
            ['arg5', 'arg6'],
        ];
    }

    /**
     * @param mixed $arg1
     * @param mixed $arg2
     *
     * @see https://phpunit.readthedocs.io/en/9.5/annotations.html
     *
     * @dataProvider dataProviderSample
     * @group        in
     * @large        (longer time)
     * @requires     extension ctype
     * @test         (alternative for naming function test...)
     * @ticket       id-1234 (alias for @group)
     */
    public function testSample($arg1, $arg2): void
    {
        $sample = new Sample();
        $this->assertEquals(5, $sample->sample(4));
        $this->assertEquals('it is text', $sample->sampleText('text'));
        $this->assertEquals('App\\Sample', $sample->sampleObject($sample));

        // Stop here and mark this test as incomplete.
        // $this->markTestIncomplete('This test has not been implemented yet.');

        if (!extension_loaded('ctype')) {
            $this->markTestSkipped(
                'The MySQLi extension is not available.'
            );
        }
    }

    /**
     * @see https://phpunit.readthedocs.io/en/9.5/assertions.html
     *
     * @depends              testSample
     * @group                in
     * @requires             PHP >= 7.1
     * @preserveGlobalState  disabled
     * @testWith             ["alternative_to", "dataProvider"]
     */
    public function testAssertions(): void
    {
        $this->assertArrayHasKey('foo', ['foo' => 'baz']);
        $this->assertClassHasAttribute('attr', SampleTest::class);
        $this->assertClassHasStaticAttribute('sAttr', SampleTest::class);
        $this->assertContains(4, [1, 4, 3]);
        $this->assertStringContainsString('foo', 'bar is foo');
        $this->assertStringContainsStringIgnoringCase('Foo', 'bar is foo');
        $this->assertContainsOnly('string', ['str1', 'str2']); //only type 'string'
        $this->assertContainsOnlyInstancesOf(stdClass::class, [new stdClass()]);
        $this->assertCount(1, ['foo']);
        $this->assertDirectoryExists(__DIR__);
        $this->assertDirectoryIsReadable(__DIR__);
        $this->assertDirectoryIsWritable(__DIR__);
        $this->assertEmpty([]);
        $this->assertEquals(1, '1');
        $this->assertEquals(['a', 'b', 'c'], ['a', 'b', 'c']);
        $this->assertEqualsCanonicalizing([3, 2, 1], [2, 3, 1]); //or sorted
        $this->assertEqualsIgnoringCase('bar', 'BaR');
        $this->assertEqualsWithDelta(10.0, 10.5, 0.5);
        $this->assertObjectEquals(new static(), new static(), 'myEqual');
        $this->assertFalse(false);
        $this->assertFileEquals(__FILE__, __FILE__);
        $this->assertFileExists(__FILE__);
        $this->assertFileIsReadable(__FILE__);
        $this->assertFileIsWritable(__FILE__);
        $this->assertGreaterThan(1, 2);
        $this->assertGreaterThanOrEqual(5, 6);
        $this->assertInfinite(INF);
        $this->assertInstanceOf(static::class, new static());
        $this->assertIsArray([]);
        $this->assertIsBool(true);
        //$this->assertIsCallable(function () {});
        $this->assertIsFloat(1.0);
        $this->assertIsInt(5);
        $this->assertIsIterable([]);
        $this->assertIsNumeric('1');
        $this->assertIsObject(new stdClass());
        $this->assertIsNotResource(null); // #resource
        $this->assertIsScalar('string');
        $this->assertIsString('string');
        $this->assertIsReadable(__FILE__);
        $this->assertIsWritable(__FILE__);
        //$this->assertJsonFileEqualsJsonFile(); // file
        //$this->assertJsonStringEqualsJsonFile(); // file
        $json = json_encode(['Mascot' => 'Tux']);
        $this->assertJsonStringEqualsJsonString($json, $json);
        $this->assertLessThan(5, 4);
        $this->assertLessThanOrEqual(5, 4);
        $this->assertNan(acos(8)); // wrong float
        $this->assertNull(null);
        $this->assertObjectHasAttribute('attr', new SampleTest());
        $this->assertMatchesRegularExpression('/foo/', 'foo');
        $this->assertStringMatchesFormat('%s-%d', 'foo-1');
        //$this->assertStringMatchesFormatFile(); // file
        $this->assertSame('2204', '2204'); // ===
        $this->assertStringEndsWith('suffix', 'foosuffix');
        //$this->assertStringEqualsFile(-file-, 'expected'); // file
        $this->assertStringStartsWith('prefix', 'prefixfoo');
        $this->assertTrue(true);
        //$this->assertXmlFileEqualsXmlFile(); // file
        //$this->assertXmlStringEqualsXmlFile(); // file
        $this->assertXmlStringEqualsXmlString('<foo><bar/></foo>', '<foo><bar/></foo>');

        // PHPUnit\Framework\Assert
        $this->assertThat(true, $this->logicalAnd(true, true));
    }

    /**
     * Stubs returns configured values.
     * @group in
     */
    public function testStub(): void
    {
        // Create a stub for the stdClass class.
        $stub = $this->createStub(static::class);
        // $trait = $this->getMockForTrait(AbstractTrait::class);
        // $abs = $this->getMockForAbstractClass(AbstractClass::class);

        // or
        $stub = $this->getMockBuilder(static::class)->getMock();

        // Configure stub and assert return values.
        $stub->expects($this->any())->method('expect')->willReturn('expectReturn');
        $this->assertSame('expectReturn', $stub->expect());

        $stub->method('doSomething')->willReturn('foo');
        $stub->method('retArg')->will($this->returnArgument(1));
        $stub->method('retSelfClass')->will($this->returnSelf());
        $stub->method('retMap')->will($this->returnValueMap([
            ['a', 'b', 'c', 'returnedValue']
        ]));
        $stub->method('iscallback')->will($this->returnCallback('strrev'));

        // Assert return values.
        $this->assertSame('foo', $stub->doSomething());
        $this->assertSame('my_arg2', $stub->retArg('my_arg1', 'my_arg2'));
        $this->assertSame($stub, $stub->retSelfClass('arg1'));
        $this->assertSame('returnedValue', $stub->retMap('a', 'b', 'c'));
        $this->assertSame('cba', $stub->iscallback('abc'));
    }

    /**
     * Used for testStub().
     */
    public function expect() {}
    public function doSomething() {}
    public function retArg() {}
    public function retSelfClass() {}
    public function retMap() {}
    public function iscallback() {}

    /**
     * Mock is an observation point that is used to verify the indirect outputs.
     * @group in
     */
    public function testMocking(): void
    {
        $mock = $this->getMockBuilder(static::class)
            //->setMethods(['method1', 'method2']) // To be mocked.
            ->setMethodsExcept(['setUp']) 
            ->setConstructorArgs(['arg1','arg2'])
            ->setMockClassName('MyMockedClass')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableAutoload()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock()
        ;

        // PHPUnit\Framework\MockObject\Matcher
        $mock->expects($this->exactly(1)) // any(), never(), once(), at()
            ->method('internalApiCall')
            ->with( 
                $this->equalTo('arg-00try11')
                /*
                $this->greaterThan(0),
                $this->stringContains('Something'),
                $this->anything()
                $this->identicalTo($expectedObject)
                $this->callback(function($subject)
                     {
                         return is_callable([$subject, 'getName']) &&
                                $subject->getName() == 'My subject';
                     }
                */
            )
            /*
            ->withConsecutive(
                [$this->equalTo('foo'), $this->greaterThan(0)],
                [$this->equalTo('bar'), $this->greaterThan(0)]
            )
            */
        ;

        // Call object.
        $realObject = new static();
        $realObject->calledFunction($mock, 'try11');
    }

    /**
     * Used for testMocking().
     */
    public function calledFunction(object $object, $arg1)
    {
        return 'Called: ' . $object->internalApiCall('arg-00' . $arg1);
    }

    /**
     * Used for testMocking().
     */
    public function internalApiCall($arg2)
    {
        return 'Api with ' . $arg2;
    }

    // https://github.com/phpspec/prophecy-phpunit
    public function _tryTestWithPhpspecProphecy()
    {
        //$this->prophesize deprecated and removed in phpunit 10
        // use phpspec/prophecy-phpunit instead
        return; 

        // create mock
        $sample = $this->prophesize(Sample::class);

        // define behavior
        $sample->sampleText(\Prophecy\Argument::Exact('something'))->shouldBeCalled();

        // Reveal the "real" object
        $mocked = $sample->reveal();

        // Call methode sampleText('something') 
        $mocked->sampleText('something');
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionCode    22
     * @expectedExceptionMessage Message
     * @group in
     */
    public function testExceptions(): void
    {
        $stub = $this->createStub(static::class);
        $stub->method('setUp')->will($this->throwException(new Exception('Message', 22)));

        $this->expectException(Exception::class);
        $stub->setUp();
    }
}
