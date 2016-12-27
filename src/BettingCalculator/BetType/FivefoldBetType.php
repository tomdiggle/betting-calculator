<?php

namespace BettingCalculator\BetType;

class FivefoldBetType implements BetType 
{
    public function name(): string
    {
        return "Fivefold";
    }

    public function totalSelections(): int
    {
        return 5;
    }

    public function totalBets(): int
    {
        return 1;
    }

    public function withSingles(): bool
    {
        return false;
    }

    public function isAccumulated(): bool
    {
        return false;
    }
}
