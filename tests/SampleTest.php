<?php

declare(strict_types=1);

namespace App\Tests;

use App\Sample;
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
     * @before                   (before EACH tests)
     * @coversNothing
     * @doesNotPerformAssertions
     */
    public function setUp(): void
    {
    }

    /**
     * @return bool
     *
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
     * @covers       ::sample
     * @dataProvider dataProviderSample
     * @group        in
     * @large        (longer time)
     * @requires     extension ctype
     * @test         (alternative for naming function test...)
     * @ticket       id-1234 (alias for @group)
     */
    public function testSample($arg1, $arg2)
    {
        $sample = new Sample();
        $this->assertEquals(5, $sample->sample(4));

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
     * @covers               ::foo
     * @depends              testSample
     * @group                in
     * @requires             PHP >= 7.1
     * @preserveGlobalState  disabled
     * @testWith             ["alternative_to", "dataProvider"]
     *
     * @uses \stdClass, SampleTest
     */
    public function testAssertions()
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
     */
    public function testStub(): void
    {
        // Create a stub for the stdClass class.
        $stub = $this->createStub(stdClass::class);

        // or
        $stub = $this->getMockBuilder(stdClass::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock()
        ;

        // Configure the stub.
        $stub->method('doSomething')->willReturn('foo');
        $stub->method('returnArg')->will($this->returnArgument(0));
        $stub->method('returnSelf')->will($this->returnSelf());

        $stub->expects($this->any())->method('doSomething')->willReturn('foo');

        // Assert return values.
        $this->assertSame('foo', $stub->doSomething());
        $this->assertSame('arg1', $stub->returnArg('arg1'));
        $this->assertSame($stub, $stub->returnArg('arg1'));
    }
}
