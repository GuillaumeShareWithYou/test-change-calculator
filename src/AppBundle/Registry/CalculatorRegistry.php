<?php

namespace AppBundle\Registry;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Calculator\Mk1Calculator;
use AppBundle\Calculator\Mk2Calculator;

class CalculatorRegistry implements CalculatorRegistryInterface {

    /** @var CalculatorInterface[] */
    private $calculators;

    public function __construct()
    {
        $this->calculators = [new Mk1Calculator(), new Mk2Calculator()];
    }

    /**
     * @param string $model Indicates the model of automaton
     *
     * @return CalculatorInterface|null The calculator, or null if no CalculatorInterface supports that model
     */
    public function getCalculatorFor(string $model): ?CalculatorInterface
    {
        foreach ($this->calculators as $calculator) {
            if($calculator->getSupportedModel() == $model)
                return $calculator;
        }
        return null;
    }
}