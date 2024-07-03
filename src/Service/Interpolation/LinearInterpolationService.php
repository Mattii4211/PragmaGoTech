<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service\Interpolation;

use PragmaGoTech\Interview\Exception\InvalidBreakpointException;
use PragmaGoTech\Interview\Service\Interpolation\InterpolationInterface;
use PragmaGoTech\Interview\Exception\InvalidLoanAmountException;
use PragmaGoTech\Interview\Model\Breakpoint;

final readonly class LinearInterpolationService implements InterpolationInterface
{
    private const MIN_LOAN_AMOUNT = 1000;
    private const MAX_LOAN_AMOUNT = 20000;

    public function calculate(float $loanAmount, Breakpoint ...$breakpoints): float
    {
        if ($this->checkLoanAmount($loanAmount)) {
           return $this->getFee($loanAmount, ...$breakpoints);
        }
    }

    private function checkLoanAmount(float $loanAmount): bool 
    {
        if ($loanAmount < self::MIN_LOAN_AMOUNT || $loanAmount > self::MAX_LOAN_AMOUNT) {
            throw new InvalidLoanAmountException();
        }

        return true;
    }

    private function getFee(float $loanAmount, Breakpoint ...$breakpoints): float
    {
        foreach ($breakpoints as $key => $breakpoint) {
            if ($loanAmount === $breakpoint->amount()) {
                return $breakpoint->fee();
            } elseif ($loanAmount < $breakpoint->amount() && $key > 0) {
                return $this->interpolate($breakpoints[$key - 1], $breakpoints[$key], $loanAmount);
            }
        }

        throw new InvalidBreakpointException();
    }

    private function interpolate(Breakpoint $minBreakpoint, Breakpoint $maxBreakpoint, float $loanAmount): float
    {
        $base = $minBreakpoint->fee();
        $delta = ($loanAmount - $minBreakpoint->amount()) / ($maxBreakpoint->amount() - $minBreakpoint->amount());
        $delta *= ($maxBreakpoint->fee() - $minBreakpoint->fee());
        $total = ceil(($loanAmount + ($base + $delta)) / 5) * 5;

        return round($total - $loanAmount, 2);
    }
}