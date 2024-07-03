<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\InterpolationStrategy;
use PragmaGoTech\Interview\Model\Breakpoint;

interface InterpolationStrategyInterface 
{
    public function calculateFee(float $loanAmount, Breakpoint ...$breakpoints): float;

    public function isSatisfiedBy(string $strategyName): bool;
}