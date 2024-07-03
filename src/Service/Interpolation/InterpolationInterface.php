<?php

declare(strict_types=1);

namespace  PragmaGoTech\Interview\Service\Interpolation;

use PragmaGoTech\Interview\Model\Breakpoint;

interface InterpolationInterface
{
    public function calculate(float $loanAmount, Breakpoint ...$breakpoints): float;
}