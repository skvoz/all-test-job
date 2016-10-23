<?php

namespace Domain\Strategy;

interface AlgorithmInterface
{
    /**
     * @param $array
     * @return array
     */
    public function execute($array);
}
