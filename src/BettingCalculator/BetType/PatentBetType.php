<?php

namespace BettingCalculator\BetType;

class PatentBetType implements BetType 
{
    public function name(): string
    {
        return "Patent";
    }

    public function totalSelections(): int
    {
        return 3;
    }

    public function totalBets(): int
    {
        return 7;
    }

    public function withSingles(): bool
    {
        return true;
    }

    public function isAccumulated(): bool
    {
        return true;
    }
}
