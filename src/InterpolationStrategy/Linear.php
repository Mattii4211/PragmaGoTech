<?php

declare(strict_types=1);

namespace  PragmaGoTech\Interview\InterpolationStrategy;

use PragmaGoTech\Interview\InterpolationStrategy\InterpolationStrategyInterface;
use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Service\Interpolation\LinearInterpolationService;

final readonly class Linear implements InterpolationStrategyInterface
{
    private const STRATEGY_NAME = 'linear';
    public function isSatisfiedBy(string $strategyName): bool
    {
        return $strategyName === self::STRATEGY_NAME;
    }

    public function calculateFee(float $loanAmount, Breakpoint ...$breakpoints): float
    {
        $calculationService = new LinearInterpolationService();
        return $calculationService->calculate($loanAmount, ...$breakpoints);
    }
}