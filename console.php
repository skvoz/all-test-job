<?php
use Domain\Command\GetDoubleFiles;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$application = new Application();

$application->add(new GetDoubleFiles());
$application->run();