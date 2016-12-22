<?php

namespace BettingCalculator\BetType;

class DoubleBetType implements BetType 
{
    public function name(): string
    {
        return "Double";
    }

    public function totalSelections(): int
    {
        return 2;
    }

    public function totalBets(): int
    {
        return 1;
    }

    public function withSingles(): bool
    {
        return false;
    }

    public function isAccumulator(): bool
    {
        return false;
    }
}
