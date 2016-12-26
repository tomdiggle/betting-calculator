<?php

namespace BettingCalculator\BetType;

class Lucky63BetType implements BetType 
{
    public function name(): string
    {
        return "Lucky 63";
    }

    public function totalSelections(): int
    {
        return 6;
    }

    public function totalBets(): int
    {
        return 63;
    }

    public function withSingles(): bool
    {
        return true;
    }

    public function isAccumulator(): bool
    {
        return true;
    }
}
