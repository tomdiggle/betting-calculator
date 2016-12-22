<?php

class BetCalculator {

    /**
     * The amount of money placed on the bet.
     *
     * @var float
     */
    private $stake;

    /**
     * True if the bet is each way, false otherwise.
     *
     * @var bool
     */
    private $eachWay;

    /**
     * The total number of selections that have been placed.
     * Should equal the total number as the bet type,
     * otherwise the bet will be invalid.
     *
     * @var int
     */
    private $totalSelections;

    /**
     * The bet type.
     *
     * @var BetType
     */
    private $betType;

    /**
     * The odds contained in the selections array.
     *
     * @var array
     */
    private $odds;

    /**
     * The statuses contained in the selections array.
     *
     * @var array
     */
    private $status;

    /**
     * The each way odds contained in the selections array.
     *
     * @var array
     */
    private $eachWayOdds;

    /**
     * An array of the running total.
     *
     * @var array
     */
    private $runningTotal;

    /**
     * The running total of the stake.
     *
     * @var array
     **/
    private $runningTotalStake;

    /**
     * An array of the running each way total.
     *
     * @var array
     **/
    private $runningTotalEachWay;

    /**
     * The running total of the return.
     *
     * @var array
     **/
    private $runningTotalReturn;

    /**
     * 
     *
     * 
     *
     * @param  float     $stake
     * @param  bool      $eachWay
     * @param  array     $selections
     * @param  BetType   $betType
     * @return void
     **/
    public function __construct(float $stake, bool $eachWay, array $selections, BetType $betType)
    {
        $this->stake = $stake;
        $this->eachWay = $eachWay;
        $this->totalSelections = count($selections);
        $this->betType = $betType;
        
        $this->odds = array_map(function($selection) {
            return $this->convertOddsToDecimal($selection->odds);
        }, $selections);
        
        $this->status = array_map(function($selection) {
            return $selection->status;
        }, $selections);

        $this->eachWayOdds = array_map(function($selection) {
            return $selection->eachWayOdds;
        }, $selections);
    }

    public function calculate()
    {
        if ($this->isInvalidBet()) {
            return [ 'outlay' => 0, 'returns' => 0, 'profit' => 0 ];
        }

        $this->runningTotal[] = $this->stake;

        // TODO: Get rid of this massive for loop hell.
        for ($j = 0; $j < $this->totalSelections; $j++) {
            $this->calculateRunningTotal(1, $j);

            for ($k = $j+1; $k < $this->totalSelections; $k++) {
                $this->calculateRunningTotal(2, $k);

                for ($l = $k+1; $l < $this->totalSelections; $l++) {
                    $this->calculateRunningTotal(3, $l);
                 }
            }
        }

        return [
            'outlay' => $this->runningTotalStake,
            'returns' => $this->runningTotalReturn,
            'profit' => $this->runningTotalReturn - $this->runningTotalStake
        ];
    }

    private function isInvalidBet(): bool
    {
        if (empty($this->stake)) {
            return true;
        } elseif ($this->totalSelections != $this->betType->totalSelections()) {
            return true;
        }

        return false;
    }

    /**
     *
     *
     * @param  int  $round
     * @param  int  $selection
     * @return void
     */
    private function calculateRunningTotal(int $round, int $selection)
    {
        $this->runningTotal[$round] = $this->calculateSingle($this->runningTotal[$round-1], $this->odds[$selection], $this->status[$selection]);

        if (!($round == 1 && !$this->betType->withSingles()) && ($this->betType->isAccumulator() || $this->betType->totalSelections() == $round)) {
            $this->runningTotalStake += $this->stake;
            $this->runningTotalReturn += $this->runningTotal[$round];
        }
    }

    /**
     * Calculates the return from a single bet.
     *
     * @param  float  $stake
     * @param  float  $odds
     * @param  string $status
     * @return float
     */
    private function calculateSingle(float $stake, float $odds, string $status): float
    {
        if ($status == "won") {
            return $stake * ($odds + 1.00);
        } elseif ($status == "void") {
            return $stake;
        }

        return 0;
    }

    /**
     * Converts odds from to decimal format.
     *
     * @param  string $odds
     * @return float
     */
    private function convertOddsToDecimal(string $odds): float
    {
        if (strpos($odds, "/")) {
            return $this->convertFractionToDecimal($odds);
        }

        return floatval($odds);
    }

    /**
     * Converts a fraction to a decimal.
     *
     * @param  string $fraction
     * @return float
     */
    private function convertFractionToDecimal(string $fraction): float
    {
        $splitFraction = explode("/", $fraction);
        $numerator = $splitFraction[0];
        $denominator = $splitFraction[1];

        if (empty($numerator) || empty($denominator)) {
            return 0;
        }

        return $numerator / $denominator;
    }
}
