<?php

namespace Domain;


use Symfony\Component\Filesystem\Filesystem;

class Result
{
    protected $resultFile = 'result.txt';
    protected $resultFolder = 'media';

    public function output($arr)
    {
        $fs = new Filesystem();
        $path = realpath($this->resultFolder) . DIRECTORY_SEPARATOR . $this->resultFile;
        if (is_writable($path) === false) {
            throw new \Exception(sprintf('<error>Exception error: file %s not writable</error>', $path));
        }
        $fs->touch($path);
        file_put_contents($path, array_map(function ($value, $key) {

            return "$key\n";
        }, $arr, array_keys($arr)));

        return true;
    }

    public function getResultPath()
    {
        return realpath($this->resultFolder) . DIRECTORY_SEPARATOR . $this->resultFile;
    }
}