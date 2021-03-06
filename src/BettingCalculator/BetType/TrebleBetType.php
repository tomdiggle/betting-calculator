<?php

namespace BettingCalculator\BetType;

class TrebleBetType implements BetType 
{
    public function name(): string
    {
        return "Treble";
    }

    public function totalSelections(): int
    {
        return 3;
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
