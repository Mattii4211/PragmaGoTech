<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\FeeStructure;
use PragmaGoTech\Interview\Repository\TermRepository;

final class FeeStructureTest extends TestCase
{
    private const int TERM = 12;
    private FeeStructure $feeStructure;
    private TermRepository $termRepository;

    protected function setUp(): void
    {
        $this->termRepository = new TermRepository();
        $this->feeStructure = new FeeStructure(
            self::TERM,
            $this->termRepository->getBreakpointsByTerm(self::TERM)->breakpoints()
        );
    }

    public function testAddBreakpointWhenNotExsist(): void
    {
        $this->assertEquals(
            true, 
            $this->feeStructure->addBreakpoint(new Breakpoint(1500, 10))
        );

        $this->assertEquals(
            array_merge(
                $this->termRepository->getBreakpointsByTerm(self::TERM)->breakpoints(),
                [new Breakpoint(1500, 10)]
            ),
            $this->feeStructure->breakpoints()
        );
    }

    public function testAddBreakpointWhenExsist(): void
    {
        $this->assertEquals(
            false, 
            $this->feeStructure->addBreakpoint(new Breakpoint(1000, 100))
        );

        $this->assertEquals(
            $this->termRepository->getBreakpointsByTerm(self::TERM)->breakpoints(),
            $this->feeStructure->breakpoints()
        );
    }

    public function testEditBreakpointWhenNotExsist(): void
    {
         $this->assertEquals(
            false, 
            $this->feeStructure->editBreakpoint(new Breakpoint(2500, 10))
        );

        $this->assertEquals(
            $this->termRepository->getBreakpointsByTerm(self::TERM)->breakpoints(),
            $this->feeStructure->breakpoints()
        );
    }

    public function testEditBreakpointWhenExsist(): void
    {
        $this->assertEquals(
            true, 
            $this->feeStructure->editBreakpoint(new Breakpoint(1000, 100))
        );

        $this->assertEquals(
            100,
            $this->feeStructure->breakpoints()[0]->fee()
        );
    }
}