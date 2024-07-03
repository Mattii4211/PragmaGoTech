<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Exception\InvalidBreakpointException;
use PragmaGoTech\Interview\Exception\InvalidLoanAmountException;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Repository\TermRepository;
use PragmaGoTech\Interview\Service\Fee\FeeCalculator;
use PragmaGoTech\Interview\Model\Term;

final class FeeCalculatorTest extends TestCase
{
    private FeeCalculator $feeCalculator;
    protected function setUp(): void
    {
        $this->feeCalculator = new FeeCalculator(new TermRepository());
    }
    public function testBaseValuesFor12(): void
    {
        $this->assertEquals(
            $this->getBaseValues(12),
            [
                $this->feeCalculator->calculate(new LoanProposal(12, 1000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 2000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 3000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 4000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 5000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 6000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 7000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 8000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 9000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 10000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 11000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 12000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 13000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 14000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 15000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 16000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 17000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 18000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 19000)),
                $this->feeCalculator->calculate(new LoanProposal(12, 20000)),
            ]
        );
    }

    public function testBaseValuesFor24(): void
    {
        $this->assertEquals(
            $this->getBaseValues(24),
            [
                $this->feeCalculator->calculate(new LoanProposal(24, 1000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 2000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 3000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 4000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 5000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 6000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 7000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 8000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 9000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 10000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 11000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 12000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 13000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 14000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 15000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 16000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 17000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 18000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 19000)),
                $this->feeCalculator->calculate(new LoanProposal(24, 20000)),
            ]
        );
    }

    public function testExampleValues(): void
    {
        $this->assertEquals(
            [
                115,
                385,
                460,
            ],
            [
                $this->feeCalculator->calculate(new LoanProposal(24, 2750)),
                $this->feeCalculator->calculate(new LoanProposal(12, 19250)),
                $this->feeCalculator->calculate(new LoanProposal(24, 11500)),
            ]
        );
    }

    public function testIncorrectRangeOfLoan(): void
    {
        $this->expectException(InvalidLoanAmountException::class);
        $this->feeCalculator->calculate(new LoanProposal(12, 750));
        $this->feeCalculator->calculate(new LoanProposal(12, 22750));
        $this->feeCalculator->calculate(new LoanProposal(24, 750));
        $this->feeCalculator->calculate(new LoanProposal(24, 22750));
    }

    public function testIncorrectBreakpoints(): void
    {
        $this->expectException(InvalidBreakpointException::class);
        $termRepository = $this->createMock(TermRepository::class);
        $termRepository->method('getBreakpointsByTerm')->willReturn(new Term(12, []));
        $feeCalculator = new FeeCalculator($termRepository);
        
        $feeCalculator->calculate(new LoanProposal(12, 1000));
        $feeCalculator->calculate(new LoanProposal(12, 100000));
        $feeCalculator->calculate(new LoanProposal(24, 1000));
        $feeCalculator->calculate(new LoanProposal(24, 100000));
    }

    private function getBaseValues(int $period): array 
    {
       $termRepository = new TermRepository();
       $expected = [];

       foreach ($termRepository->getBreakpointsByTerm($period)->breakpoints() as $breakpoint) {
            $expected[] = $breakpoint->fee();
       }

       return $expected;
    }
}