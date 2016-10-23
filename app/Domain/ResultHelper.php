<?php

namespace Domain;

use Symfony\Component\Filesystem\Filesystem;

class ResultHelper
{
    const DEFAULT_PATH = 'media/result.txt';

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ? $filesystem : new Filesystem();
    }

    public function successMessage($message)
    {
        return sprintf('<info>%s</info>', $message);
    }

    public function errorMessage($message)
    {
        return sprintf('<error>%s</error>', $message);
    }

    public function saveToFile($array, $path = null)
    {
        $path = $path ? $path : self::DEFAULT_PATH;

        try {
            $this->filesystem->touch($path);

            file_put_contents($path, array_map(function ($value, $key) {

                return "$key\n";
            }, $array, array_keys($array)));
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    public function getResultPath($path)
    {
        $path = $path ? realpath($path) . DIRECTORY_SEPARATOR . 'result.txt' : realpath('') . DIRECTORY_SEPARATOR . self::DEFAULT_PATH ;

        return $path;
    }
}
