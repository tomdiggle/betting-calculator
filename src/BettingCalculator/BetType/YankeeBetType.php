<?php

namespace BettingCalculator\BetType;

class YankeeBetType implements BetType 
{
    public function name(): string
    {
        return "Yankee";
    }

    public function totalSelections(): int
    {
        return 4;
    }

    public function totalBets(): int
    {
        return 11;
    }

    public function withSingles(): bool
    {
        return false;
    }

    public function isAccumulated(): bool
    {
        return true;
    }
}
