<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Exception\BreakpointAlreadyExsistException;
use PragmaGoTech\Interview\Exception\BreakpointNotFoundException;
use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Repository\TermRepository;
use PragmaGoTech\Interview\Service\FeeStructure\FeeStructureService;

final class FeeStructureServiceTest extends TestCase
{
    private const int TERM = 12;
    private FeeStructureService $feeStructureService;
    private TermRepository $termRepository;
    private iterable $breakpoints;

    protected function setUp(): void
    {
        $this->termRepository = new TermRepository();
        $this->feeStructureService = new FeeStructureService();
        $this->breakpoints = $this->termRepository->getBreakpointsByTerm(self::TERM)->breakpoints();
    }

    public function testAddBreakpointWhenNotExsist(): void
    {

        $newBreakpoints = $this->feeStructureService->add(new Breakpoint(1500, 10), $this->breakpoints);

        $newArray = (array)array_merge(
            $this->termRepository->getBreakpointsByTerm(self::TERM)->breakpoints(), 
            [new Breakpoint(1500, 10)]
        );
        usort($newArray, fn($a, $b) => $a->amount() > $b->amount());
        $this->assertEquals(
            $newArray,
            $newBreakpoints
        );
    }

    public function testAddBreakpointWhenExsist(): void
    {
        $this->expectException(BreakpointAlreadyExsistException::class);
        $this->feeStructureService->add(new Breakpoint(1000, 100), $this->breakpoints);
    }

    public function testEditBreakpointWhenNotExsist(): void
    {
        $this->expectException(BreakpointNotFoundException::class);
        $this->feeStructureService->edit(new Breakpoint(2500, 10), $this->breakpoints);
    }

    public function testEditBreakpointWhenExsist(): void
    {
        $editBreakpoints = $this->feeStructureService->edit(new Breakpoint(1000, 100), $this->breakpoints);

        $this->assertEquals(
            100,
            $editBreakpoints[0]->fee()
        );
    }
}