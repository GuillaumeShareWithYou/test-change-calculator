<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/14/19
 * Time: 9:41 PM
 */

namespace AppBundle\Calculator;


use AppBundle\Model\Change;

class Mk2Calculator implements CalculatorInterface
{


    /**
     * @return string Indicates the model of automaton
     */
    public function getSupportedModel(): string
    {
        return "mk2";
    }

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        $coins = [10, 5, 2];
        $counts = [0, 0, 0];
        $i = 0;

        while ($i < count($coins)) {
            $n = floor($amount / $coins[$i]);
            $counts[$i] = $n;
            $amount -= $n * $coins[$i];
            $i++;
        }

        if ($amount > 0) {
            return null; // Change impossible
        }

        $change = new Change();
        $change->bill10 = $counts[0];
        $change->bill5 = $counts[1];
        $change->coin2 = $counts[2];
        return $change;
    }

}