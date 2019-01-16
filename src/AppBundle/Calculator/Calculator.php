<?php

namespace AppBundle\Calculator;

use AppBundle\Model\Change;

abstract class Calculator implements CalculatorInterface
{

    private $availableChanges = [];

    /**
     * Calculator constructor.
     * @param array $availableChanges
     */
    public function __construct(array $availableChanges = [])
    {
        $this->availableChanges = $availableChanges;
    }


    /**
     * @return string Indicates the model of automaton
     */
    public abstract function getSupportedModel(): string;

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        $counts = [];
        $i = 0;
        rsort($this->availableChanges);
        $nbChanges = count($this->availableChanges);
        while ($i < $nbChanges) {
            $n = floor($amount / $this->availableChanges[$i]);
            $virtualAmount = $amount - ($n * $this->availableChanges[$i]);

            if ($n > 0 &&
                // Suivant n'est pas dernier, suivant STRICTEMENT inferieur au montant restant et dernier ne permettant pas de conclure
                ((($i + 1) < $nbChanges && $virtualAmount < $this->availableChanges[$i + 1] && ($virtualAmount % $this->availableChanges[$nbChanges - 1] != 0))
                // dernier permettant pas de conclure
                || (($i + 1) == ($nbChanges - 1) && ($virtualAmount % $this->availableChanges[$i + 1] != 0)))
            ) {
                $n--;
            }
            $counts[$i] = $n;
            $amount -= $n * $this->availableChanges[$i];
            $i++;
        }
        if ($amount != 0) {
            return null; // Change impossible
        }

        $change = new Change();

        foreach ($this->availableChanges as $key => $value) {
            if ($value) {
                $m = ($this->availableChanges[$key] < 5 ? 'coin' : 'bill') . $value;
                $change->$m = $counts[$key];
            }
        }
        return $change;
    }


    /**
     * @return array
     */
    public function getAvailableChanges(): array
    {
        return $this->availableChanges;
    }

    /**
     * @param array $availableChanges
     */
    public function setAvailableChanges(array $availableChanges): void
    {
        $this->availableChanges = $availableChanges;
    }


}