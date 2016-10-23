<?php

namespace Tests;

use Domain\Strategy\ObjectCollection;
use Domain\Strategy\SplAlgorithm;

class ObjectCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectCollection;
     */
    private $instance;
    /**
     * @var SplAlgorithm | PHPUnit_Framework_MockObject_MockBuilder
     */
    private $mockAlgorithm;

    public function setUp()
    {
        $this->instance = new ObjectCollection();
        $this->mockAlgorithm = $this->getMockBuilder(SplAlgorithm::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {

    }

    public function testSuccessExtractDoubles()
    {
        $elements = [
            'foo/foo.txt' => 'foo.txt',
            'foo/bar/foo.txt' => 'foo.txt',
            'foo/bar.txt' => 'bar.txt',
        ];

        $doubleElements = [
            'foo/bar/foo.txt' => 'foo.txt',
        ];

        $this->instance->setElements($elements);
        $this->instance->setAlgorithm($this->mockAlgorithm);

        $this->mockAlgorithm
            ->expects($this->once())
            ->method('execute')
            ->with($elements)
            ->willReturn($doubleElements);

        $result = $this->instance->extractDoubles();

        $this->assertEquals($result, $doubleElements);
    }

    /**
     * @expectedException        \LogicException
     * @expectedExceptionMessage Algorithm is not set
     */
    public function testExceptionNoneAlgorithmExtractDoubles()
    {
        $elements = [
            'foo/foo.txt' => 'foo.txt',
            'foo/bar/foo.txt' => 'foo.txt',
            'foo/bar.txt' => 'bar.txt',
        ];

        $this->instance->setElements($elements);
        $this->instance->extractDoubles();
    }
}
