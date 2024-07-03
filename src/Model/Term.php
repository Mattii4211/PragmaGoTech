<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

final readonly class Term
{
    public function __construct(private int $period, private iterable $breakpoints)
    {}

    public function period(): int
    {
        return $this->period;
    }

    public function breakpoints(): iterable
    {
        return $this->breakpoints;
    }
}