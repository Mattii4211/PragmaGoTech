<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

final readonly class Breakpoint
{
    public function __construct(private float $amount, private float $fee)
    {}

    public function amount(): float
    {
        return $this->amount;
    }

    public function fee(): float
    {
        return $this->fee;
    }
}