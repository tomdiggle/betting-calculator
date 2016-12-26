<?php

namespace BettingCalculator\BetType;

class Lucky15BetType implements BetType 
{
    public function name(): string
    {
        return "Lucky 15";
    }

    public function totalSelections(): int
    {
        return 4;
    }

    public function totalBets(): int
    {
        return 15;
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
