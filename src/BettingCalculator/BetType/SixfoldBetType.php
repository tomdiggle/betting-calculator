<?php

namespace BettingCalculator\BetType;

class SixfoldBetType implements BetType 
{
    public function name(): string
    {
        return "Sixfold";
    }

    public function totalSelections(): int
    {
        return 6;
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
