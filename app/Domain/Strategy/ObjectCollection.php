<?php

namespace Domain\Strategy;

class ObjectCollection
{
    /**
     * @var array
     */
    private $elements;

    /**
     * @var AlgorithmInterface
     */
    private $algorithm;

    /**
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function extractDoubles()
    {
        if (!$this->algorithm) {
            throw new \LogicException('Algorithm is not set');
        }

        $result = $this->algorithm->execute($this->elements);

        return $result;
    }

    /**
     * @param AlgorithmInterface $algorithm
     */
    public function setAlgorithm(AlgorithmInterface $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * @param array $elements
     */
    public function setElements($elements = [])
    {
        $this->elements = $elements;
    }
}
