<?php

namespace Tests;

use Domain\Strategy\SplAlgorithm;

class SplAlgorithmTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SplAlgorithm
     */
    private $instace;

    public function setUp()
    {
        $this->instace = new SplAlgorithm();
    }

    public function testIndex()
    {
        $elements = [
            'foo/foo.txt' => 'foo.txt',
            'foo/bar/foo.txt' => 'foo.txt',
            'foo/bar.txt' => 'bar.txt',
        ];

        $doubleElements = [
            'foo/bar/foo.txt' => 'foo.txt',
        ];
        $result = $this->instace->execute($elements);

        $this->assertEquals($result, $doubleElements);
    }
}
