<?php

namespace Domain\Strategy;

class SplAlgorithm implements AlgorithmInterface
{
    /**
     * @param $arrayElement
     * @return array
     */
    public function execute($arrayElement)
    {
        $arrayUniqueElement = array_unique($arrayElement);

        $result = array_diff_key($arrayElement, $arrayUniqueElement);

        return $result;
    }
}
