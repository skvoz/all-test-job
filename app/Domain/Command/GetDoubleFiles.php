<?php

namespace Domain\Command;

use Domain\Result;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetDoubleFiles extends Command
{
    protected function configure()
    {
        $this
            ->setName('files:get-double')
            ->setDescription('Take doubles files.')
            ->setHelp("This command allows you to take double files.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arrayElement = [];

        try {
            $path = realpath('media/dir');

            $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
            /**
             * @var  $name
             * @var  SplFileInfo $object
             */
            foreach ($objects as $name => $object) {

                $fileName = $object->getFilename();

                if ($fileName == '.' || $fileName == '..' || $object->isFile() === false)
                    continue;

                $arrayElement[$name] = $object->getFilename();
            }

            $arrayUniqueElement = array_unique($arrayElement);

            $result = array_diff_key($arrayElement, $arrayUniqueElement);

            $resultObject = new Result();
            $resultObject->output($result);

            $output->writeln(sprintf('<info>Success! Result at %s</info>', $resultObject->getResultPath()));

        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>Exception error: %s</error>', $e->getMessage()));
        }


    }
}