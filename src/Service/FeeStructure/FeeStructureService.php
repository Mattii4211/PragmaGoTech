<?php 

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service\FeeStructure;

use PragmaGoTech\Interview\Exception\BreakpointAlreadyExsistException;
use PragmaGoTech\Interview\Exception\BreakpointNotFoundException;
use PragmaGoTech\Interview\Model\Breakpoint;

final readonly class FeeStructureService
{
    public function add(Breakpoint $breakpoint, iterable $breakpoints): iterable
    {
        if (!$this->checkAlreadyExsist($breakpoint, $breakpoints)) {
            return array_merge($breakpoints, [$breakpoint]);
        }

        throw new BreakpointAlreadyExsistException();
    }

    public function edit(Breakpoint $newBreakpoint, iterable $breakpoints): iterable
    {
        if ($this->checkAlreadyExsist($newBreakpoint, $breakpoints)) {
            $newBreakpoints = [];
            
            foreach ($breakpoints as $breakpoint) {
                if ($breakpoint->amount() === $newBreakpoint->amount()) {
                    $newBreakpoints[] = $newBreakpoint;
                } else {
                    $newBreakpoints[] = $breakpoint;
                }
            }

            return $newBreakpoints;
        }
        
        throw new BreakpointNotFoundException();
    }

    private function checkAlreadyExsist(Breakpoint $newBreakpoint, iterable $breakpoints): bool
    {
        foreach ($breakpoints as $breakpoint) {
            if ($breakpoint->amount() === $newBreakpoint->amount()) {
                return true;
            }
        }
        return false;
    }
}