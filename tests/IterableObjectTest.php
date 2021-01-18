<?php

use BenTools\IterableFunctions\IterableObject;
use PHPUnit\Framework\TestCase;
use function BenTools\IterableFunctions\iterable;

final class IterableObjectTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFromArrayToIterator($expectedResult, $data, $filter = null, $map = null): void
    {
        $iterableObject = iterable($data, $filter, $map);
        $this->assertInstanceOf(IterableObject::class, $iterableObject);
        $this->assertEquals($expectedResult, iterator_to_array($iterableObject));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFromArrayToArray($expectedResult, $data, $filter = null, $map = null): void
    {
        $iterableObject = iterable($data, $filter, $map);
        $this->assertInstanceOf(IterableObject::class, $iterableObject);
        $this->assertEquals($expectedResult, $iterableObject->asArray());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFromTraversableToIterator($expectedResult, $data, $filter = null, $map = null): void
    {
        $data = SplFixedArray::fromArray($data);
        $iterableObject = iterable($data, $filter, $map);
        $this->assertInstanceOf(IterableObject::class, $iterableObject);
        $this->assertEquals($expectedResult, iterator_to_array($iterableObject));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFromTraversableToArray($expectedResult, $data, $filter = null, $map = null): void
    {
        $data = SplFixedArray::fromArray($data);
        $iterableObject = iterable($data, $filter, $map);
        $this->assertInstanceOf(IterableObject::class, $iterableObject);
        $this->assertEquals($expectedResult, $iterableObject->asArray());
    }

    public function dataProvider()
    {
        $data = ['foo', 'bar'];
        $filter = static function ($value) {
            return 'bar' === $value;
        };
        $map = 'strtoupper';

        return [
            [
                ['foo', 'bar'],
                $data,
                null,
                null
            ],
            [
                [1 => 'bar'],
                $data,
                $filter,
                null
            ],
            [
                ['FOO', 'BAR'],
                $data,
                null,
                $map
            ],
            [
                [1 => 'BAR'],
                $data,
                $filter,
                $map
            ],
        ];
    }

}
