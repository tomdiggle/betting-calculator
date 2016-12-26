<?php

namespace BettingCalculator\BetType;

class SevenfoldBetType implements BetType 
{
    public function name(): string
    {
        return "Sevenfold";
    }

    public function totalSelections(): int
    {
        return 7;
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
