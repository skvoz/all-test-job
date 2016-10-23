<?php

namespace Tests;

use Domain\ResultHelper;
use Symfony\Component\Filesystem\Filesystem;

class ResultHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResultHelper
     */
    private $instance;
    /**
     * @var Filesystem | \PHPUnit_Framework_MockObject_MockBuilder
     */
    private $mockFileSystem;

    public function setUp()
    {
        $this->mockFileSystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->instance = new ResultHelper($this->mockFileSystem);
    }

    public function tearDown()
    {
        $filesystem = new Filesystem();
        $filesystem->remove(realpath('media/testResult.txt'));
    }

    public function testSuccessMessage()
    {
        $message = 'hello world!!!';
        $this->assertEquals($this->instance->successMessage($message), sprintf('<info>%s</info>', $message));
    }

    public function testErrorMessage()
    {
        $message = 'hello world!!!';
        $this->assertEquals($this->instance->errorMessage($message), sprintf('<error>%s</error>', $message));
    }

    public function testSuccessSaveToFile()
    {
        $array = [1 => "foo", 2 => "bar"];
        $path = 'media/testResult.txt';

        $this->mockFileSystem
            ->expects($this->once())
            ->method('touch')
            ->with($path);

        $result = $this->instance->saveToFile($array, $path);

        $this->assertTrue($result);
        $this->assertTrue(is_file(realpath($path)));
        $output = file(realpath($path), FILE_IGNORE_NEW_LINES);
        $this->assertEquals($output, [1, 2]);
    }
}
