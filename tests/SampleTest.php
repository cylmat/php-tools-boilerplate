<?php

namespace App\Tests;

use App\Sample;
use PHPUnit\Framework\TestCase;

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
    private static $s_attr;

    public function setUp(): void
    {
    }

    /**
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
     * @see https://phpunit.readthedocs.io/en/9.5/annotations.html
     *
     * @after: after test method
     *
     * @group in
     */
    public function testSample(): void
    {
        $sample = new Sample();
        $this->assertEquals(5, $sample->sample(4));
    }

    /**
     * @see https://phpunit.readthedocs.io/en/9.5/assertions.html.
     *
     * @group in
     */
    public function testAssertions(): void
    {
        $this->assertArrayHasKey('foo', ['foo' => 'baz']);
        $this->assertClassHasAttribute('attr', SampleTest::class);
        $this->assertClassHasStaticAttribute('s_attr', SampleTest::class);
        $this->assertContains(4, [1, 4, 3]);
        $this->assertStringContainsString('foo', 'bar is foo');
        $this->assertStringContainsStringIgnoringCase('Foo', 'bar is foo');
        $this->assertContainsOnly('string', ['str1', 'str2']); //only type 'string'
        $this->assertContainsOnlyInstancesOf(\stdClass::class, [new \stdClass()]);
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
        $this->assertIsCallable(
            function () {
            }
        );
        $this->assertIsFloat(1.0);
        $this->assertIsInt(5);
        $this->assertIsIterable([]);
        $this->assertIsNumeric('1');
        $this->assertIsObject(new \stdClass());
        $this->assertIsNotResource(null); // #resource
        $this->assertIsScalar('string');
        $this->assertIsString('string');
        $this->assertIsReadable(__FILE__);
        $this->assertIsWritable(__FILE__);
        //$this->assertJsonFileEqualsJsonFile(); // file
        //$this->assertJsonStringEqualsJsonFile(); // file
        $this->assertJsonStringEqualsJsonString(json_encode(['Mascot' => 'Tux']), json_encode(['Mascot' => 'Tux']));
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
     * @todo
     */
    public function testMock()
    {
    }
}
