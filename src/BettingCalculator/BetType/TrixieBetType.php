<?php

namespace BettingCalculator\BetType;

class TrixieBetType implements BetType 
{
    public function name(): string
    {
        return "Trixie";
    }

    public function totalSelections(): int
    {
        return 3;
    }

    public function totalBets(): int
    {
        return 4;
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
