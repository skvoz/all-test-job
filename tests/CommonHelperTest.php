<?php

namespace Tests;

use Domain\CommonHelper;
use Symfony\Component\Filesystem\Filesystem;

class CommonHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommonHelper
     */
    private $instance;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function setUp()
    {
        $this->instance = new CommonHelper();
        $this->filesystem = new Filesystem();
        $path = realpath('media') . DIRECTORY_SEPARATOR . 'testDir';
        $this->filesystem->mkdir($path);
    }

    public function tearDown()
    {
        $this->filesystem->remove(realpath('media') . DIRECTORY_SEPARATOR . 'testDir');
    }

    public function testSuccessGetDirectoryTreeArray()
    {
        $testPatternArray = [
            '/dir1\/dir11\/file3.txt/',
            '/dir1\/file1.txt/',
            '/dir2\/file2.txt/',
            '/dir3\/file3.txt/',
        ];
        $path = realpath('media') . DIRECTORY_SEPARATOR . 'testDir';

        $this->prepareDir($path);

        $result = $this->instance->getDirectoryTreeArray($path);

        $i = 0;
        foreach ($result as $order => $item) {
            $this->assertRegExp($testPatternArray[$i], $order);
            $i++;
        }
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Unexist search directory
     */
    public function testUnExistDirGetDirectoryTreeArray()
    {
        $this->instance->getDirectoryTreeArray('111');
    }

    public function prepareDir($rootPath)
    {

        $this->filesystem->mkdir($rootPath . DIRECTORY_SEPARATOR . 'dir1');
        $this->filesystem->mkdir($rootPath . DIRECTORY_SEPARATOR . 'dir2');
        $this->filesystem->mkdir($rootPath . DIRECTORY_SEPARATOR . 'dir3');
        $this->filesystem->mkdir($rootPath . DIRECTORY_SEPARATOR . 'dir1' . DIRECTORY_SEPARATOR .
            'dir11');

        $this->filesystem->touch($rootPath . DIRECTORY_SEPARATOR . 'dir1' . DIRECTORY_SEPARATOR . 'file1.txt');
        $this->filesystem->touch($rootPath . DIRECTORY_SEPARATOR . 'dir2' . DIRECTORY_SEPARATOR . 'file2.txt');
        $this->filesystem->touch($rootPath . DIRECTORY_SEPARATOR . 'dir3' . DIRECTORY_SEPARATOR . 'file3.txt');
        $this->filesystem->touch($rootPath . DIRECTORY_SEPARATOR . 'dir1' .
            DIRECTORY_SEPARATOR . 'dir11' . DIRECTORY_SEPARATOR . 'file3.txt');
    }

}
