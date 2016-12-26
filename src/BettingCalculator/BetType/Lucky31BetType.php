<?php

namespace BettingCalculator\BetType;

class Lucky31BetType implements BetType 
{
    public function name(): string
    {
        return "Lucky 31";
    }

    public function totalSelections(): int
    {
        return 5;
    }

    public function totalBets(): int
    {
        return 31;
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
