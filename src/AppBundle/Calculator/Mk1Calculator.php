<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/14/19
 * Time: 9:41 PM
 */

namespace AppBundle\Calculator;


use AppBundle\Model\Change;

class Mk1Calculator extends Calculator
{
    public function __construct()
    {
        parent::__construct([1]);
    }

    /**
     * @return string Indicates the model of automaton
     */
    public function getSupportedModel(): string
    {
        return "mk1";
    }

}