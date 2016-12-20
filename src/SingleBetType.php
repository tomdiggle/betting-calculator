<?php

class SingleBetType implements BetType 
{
    public function name(): string
    {
        return "Single";
    }

    public function totalSelections(): int
    {
        return 1;
    }

    public function totalBets(): int
    {
        return 1;
    }

    public function withSingles(): bool
    {
        return true;
    }

    public function isAccumulator(): bool
    {
        return false;
    }
}
