<?php

namespace Domain;

use Prophecy\Exception\Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class CommonHelper
{
    /**
     * only for directory with files
     * @param $path - full path
     * @return array
     * @throws \Exception
     */
    public function getDirectoryTreeArray($path = null)
    {
        $path = $path ? realpath($path) : realpath('media/dir');

        if (is_writable($path) === false) {
            throw new \Exception('Unexist search directory');
        }

        $arrayElement = [];

        $objects = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::SELF_FIRST
        );

        /**
         * @var  $name
         * @var  SplFileInfo $object
         */
        foreach ($objects as $name => $object) {
            $fileName = $object->getFilename();
            $isFile = $object->isFile();

            if ($fileName === '.' || $fileName === '..' || $isFile === false) {
                continue;
            }

            $arrayElement[$name] = $object->getFilename();
        }

        return $arrayElement;
    }
}
