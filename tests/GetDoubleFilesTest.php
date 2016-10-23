<?php

namespace Tests;

use Command\GetDoubleFiles;
use Domain\CommonHelper;
use Domain\ResultHelper;
use Domain\Strategy\ObjectCollection;
use Domain\Strategy\SplAlgorithm;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class GetDoubleFilesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Command
     */
    private $command;

    /**
     * @var CommonHelper | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockHelper;

    /**
     * @var ObjectCollection | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockCollection;

    /**
     * @var SplAlgorithm | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockAlgorithm;
    /**
     * @var ResultHelper | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockResult;

    public function setUp()
    {
        $this->prepareData();

        $this->mockHelper = $this->getMockBuilder(CommonHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockCollection = $this->getMockBuilder(ObjectCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockAlgorithm = $this->getMockBuilder(SplAlgorithm::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockResult = $this->getMockBuilder(ResultHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $application = new Application();

        $commandRealization = new GetDoubleFiles(
            $this->mockHelper,
            $this->mockCollection,
            $this->mockAlgorithm,
            $this->mockResult
        );

        $application->add($commandRealization);

        $this->command = $application->find('files:get-double');

    }

    public function tearDown()
    {
        //TODO only for nix , not good
        $path = realpath('media') . DIRECTORY_SEPARATOR . 'dir1';
        exec('rm -rf ' . $path);
    }
    public function testSuccessExecute()
    {
        $this->prepareData();

        $successMessage = "111";
        $path = 'media/dir1';
        $fakeElArray = [
            'foo',
            'bar'
        ];

        $fakeResult = [
            'bar',
            'baz'
        ];

        $this
            ->mockResult
            ->expects($this->any())
            ->method('successMessage')
            ->willReturn($successMessage);

        $this
            ->mockHelper
            ->expects($this->any())
            ->method('getDirectoryTreeArray')
            ->with($path)
            ->willReturn($fakeElArray);

        $this
            ->mockCollection
            ->expects($this->any())
            ->method('setElements')
            ->with($fakeElArray);

        $this
            ->mockCollection
            ->expects($this->any())
            ->method('setAlgorithm')
            ->with($this->mockAlgorithm);

        $this
            ->mockCollection
            ->expects($this->any())
            ->method('extractDoubles')
            ->willReturn($fakeResult);

        $this
            ->mockResult
            ->expects($this->any())
            ->method('getResultPath')
            ->willReturn($path);

        $this
            ->mockResult
            ->expects($this->any())
            ->method('saveToFile')
            ->with($fakeResult, $path);

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(array(
            'command'  => $this->command->getName(),
            'path' => $path,
        ));
        $output = $commandTester->getDisplay(true);
        $this->assertEquals($successMessage . "\n", $output);
    }

    public function testExceptionExecute()
    {
        $path = 'media/dir11';

        $errorMessage = sprintf('Exception error: %s', 'Unexist search directory');

        $this
            ->mockHelper
            ->expects($this->any())
            ->method('getDirectoryTreeArray')
            ->will($this->returnCallback(function() {
                throw new \Exception('Unexist search directory');
            }));

        $this
            ->mockResult
            ->expects($this->any())
            ->method('errorMessage')
            ->willReturn($errorMessage);

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(array(
            'command' => $this->command->getName(),
            'path' => $path,
        ));

        $output = $commandTester->getDisplay();

        $this->assertEquals($output, $errorMessage . "\n");
    }

    private function prepareData()
    {
        $path = realpath('media') . DIRECTORY_SEPARATOR . 'dir1';

        if (is_writable($path) == false)
            mkdir($path);

        file_put_contents($path . DIRECTORY_SEPARATOR .
            'file.txt', 'hello world');
    }
}