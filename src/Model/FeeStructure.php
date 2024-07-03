<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

use PragmaGoTech\Interview\Exception\BreakpointAlreadyExsistException;
use PragmaGoTech\Interview\Exception\BreakpointNotFoundException;
use PragmaGoTech\Interview\Service\FeeStructure\FeeStructureService;

final class FeeStructure
{
    private FeeStructureService $feeStructureService;

    public function __construct(private int $period, private iterable $breakpoints)
    {
        $this->feeStructureService = new FeeStructureService();
    }

    public function period(): int
    {
        return $this->period;
    }

    public function breakpoints(): iterable
    {
        return $this->breakpoints;
    }

    public function addBreakpoint(Breakpoint $breakpoint): bool
    {
        try {
            $this->breakpoints = $this->feeStructureService->add($breakpoint, $this->breakpoints);
        } catch (BreakpointAlreadyExsistException $e) {
        }
        
        return !isset($e);
    }

    public function editBreakpoint(Breakpoint $breakpoint): bool
    {
        try {
            $this->breakpoints = $this->feeStructureService->edit($breakpoint, $this->breakpoints);
        } catch (BreakpointNotFoundException $e) {
        }

        return !isset($e);
    }
}