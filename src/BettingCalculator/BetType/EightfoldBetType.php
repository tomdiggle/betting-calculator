<?php

namespace BettingCalculator\BetType;

class EightfoldBetType implements BetType 
{
    public function name(): string
    {
        return "Eightfold";
    }

    public function totalSelections(): int
    {
        return 8;
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
