<?php 

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service\Fee;

use PragmaGoTech\Interview\Exception\NotStrategyFoundException;
use PragmaGoTech\Interview\Service\Fee\FeeCalculatorInterface;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\InterpolationStrategy\Linear;
use PragmaGoTech\Interview\Repository\TermRepository;

final readonly class FeeCalculator implements FeeCalculatorInterface
{
    private const STRATEGIES = [
        Linear::class
    ];

    public function __construct(
        private TermRepository $termRepository,
        private string $strategyType = 'linear'
    ) {}

    public function calculate(LoanProposal $application): float
    {
        foreach (self::STRATEGIES as $strategy) {
            $strategy = new $strategy();
            if ($strategy->isSatisfiedBy($this->strategyType)) {
                return $strategy->calculateFee(
                    $application->amount(),
                    ...$this->termRepository->getBreakpointsByTerm($application->term())->breakpoints()
                );
            } else {
                throw new NotStrategyFoundException();
            }
        }
    }
}