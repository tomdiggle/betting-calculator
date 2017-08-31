<?php

namespace BettingCalculator\BetType;

interface BetType
{
    /**
     * The name of the bet type.
     *
     * @return string
     */
    public function name(): string;

    /**
     * The total number of selections in the bet type.
     *
     * @return int
     */
    public function totalSelections(): int;

    /**
     * The total number of bets in the bet type.
     *
     * @return int
     */
    public function totalBets(): int;

    /**
     * Returns true if the bet types has single bets, false otherwise.
     *
     * @return bool
     */
    public function withSingles(): bool;

    /**
     * Returns true if the bet type's total is accumulated, false otherwise.
     *
     * @return bool
     */
    public function isAccumulated(): bool;
}
