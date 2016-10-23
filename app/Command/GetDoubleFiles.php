<?php

namespace Command;

use Domain\CommonHelper;
use Domain\ResultHelper;
use Domain\Strategy\ObjectCollection;
use Domain\Strategy\SplAlgorithm;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetDoubleFiles extends Command
{
    const DEFAULT_PATH = 'media/dir';

    /**
     * @var CommonHelper
     */
    private $helper;

    /**
     * @var ObjectCollection
     */
    private $collection;

    /**
     * @var SplAlgorithm
     */
    private $algorithm;

    /**
     * @var ResultHelper
     */
    private $result;

    public function __construct(
        CommonHelper $helper = null,
        ObjectCollection $collection = null,
        SplAlgorithm $algorithm = null,
        ResultHelper $result = null
    ) {
        parent::__construct();

        $this->helper = $helper ? $helper : new CommonHelper();
        $this->collection = $collection ? $collection : new ObjectCollection();
        $this->algorithm = $algorithm ? $algorithm : new SplAlgorithm();
        $this->result = $result ? $result : new ResultHelper();
    }

    protected function configure()
    {
        $this
            ->setName('files:get-double')
            ->setDescription('Take doubles files.')
            ->setHelp("This command allows you to take double files.")
            ->addArgument('path', InputArgument::OPTIONAL, 'Default path "media/dir"');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $path = $input->getArgument('path');

            $arrayElement = $this->helper->getDirectoryTreeArray($path);

            $this->collection->setElements($arrayElement);

            $this->collection->setAlgorithm($this->algorithm);

            $result = $this->collection->extractDoubles();

            $this->result->saveToFile($result, $this->result->getResultPath($path));

            $output->writeln($this->result->successMessage(sprintf('Success! Result at %s', $this->result->getResultPath($path))));
        } catch (\Exception $e) {
            $output->writeln($this->result->errorMessage(sprintf('Exception error: %s</error>', $e->getMessage())));
        }
    }
}
