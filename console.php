<?php
use Command\GetDoubleFiles;
use Command\PrepareData;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$application = new Application();

$application->add(new GetDoubleFiles());
$application->add(new PrepareData());
$application->run();