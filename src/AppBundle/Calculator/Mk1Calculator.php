<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/14/19
 * Time: 9:41 PM
 */

namespace AppBundle\Calculator;


use AppBundle\Model\Change;

class Mk1Calculator implements CalculatorInterface
{

    /**
     * @return string Indicates the model of automaton
     */
    public function getSupportedModel(): string
    {
        return "mk1";
    }

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        $change = new Change();
        $change->coin1 = $amount;
        return $change;
    }
}