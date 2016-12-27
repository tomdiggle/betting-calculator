<?php

namespace BettingCalculator\BetType;

interface BetType
{
    /**
     * 
     *
     * @return 
     */
    public function name(): string;

    /**
     * 
     *
     * @return
     */
    public function totalSelections(): int;

    /**
     * 
     *
     * @return
     */
    public function totalBets(): int;

    /**
     * 
     *
     * @return
     */
    public function withSingles(): bool;

    /**
     * 
     *
     * @return
     */
    public function isAccumulated(): bool;
}
