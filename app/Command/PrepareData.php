<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class PrepareData extends Command
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem();
    }

    protected function configure()
    {
        $this
            ->setName('files:generate')
            ->setDescription('Generate tree')
            ->setHelp("This command generate  tree folder files.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->filesystem->mkdir('media/dir');
        $path = realpath('media/dir');
        $this->filesystem->mkdir($path . DIRECTORY_SEPARATOR . 'dir1');
        $this->filesystem->mkdir($path . DIRECTORY_SEPARATOR . 'dir2');
        $this->filesystem->mkdir($path . DIRECTORY_SEPARATOR . 'dir3');
        $this->filesystem->mkdir($path . DIRECTORY_SEPARATOR . 'dir1' . DIRECTORY_SEPARATOR .
            'dir11');

        $this->filesystem->touch($path . DIRECTORY_SEPARATOR . 'dir1' . DIRECTORY_SEPARATOR .
            'dir11' . DIRECTORY_SEPARATOR . 'file1.php');
        $this->filesystem->touch($path . DIRECTORY_SEPARATOR . 'dir1' . DIRECTORY_SEPARATOR .
            'dir11' . DIRECTORY_SEPARATOR . 'file2.php');
        $this->filesystem->touch($path . DIRECTORY_SEPARATOR . 'dir1' . DIRECTORY_SEPARATOR .
            'dir11' . DIRECTORY_SEPARATOR . 'file3.php');

        $this->filesystem->touch($path . DIRECTORY_SEPARATOR . 'dir2' . DIRECTORY_SEPARATOR .
            'file3.php');

        $this->filesystem->touch($path . DIRECTORY_SEPARATOR . 'dir3' . DIRECTORY_SEPARATOR .
            'file1.php');
        $this->filesystem->touch($path . DIRECTORY_SEPARATOR . 'dir3' . DIRECTORY_SEPARATOR .
            'file4.php');
    }
}
