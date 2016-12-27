<?php

namespace BettingCalculator\BetType;

class FourfoldBetType implements BetType 
{
    public function name(): string
    {
        return "Fourfold";
    }

    public function totalSelections(): int
    {
        return 4;
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
