<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Repository;

use PragmaGoTech\Interview\Model\FeeStructure;

interface BaseTermInterface
{
    public function getBreakpointsByTerm(int $term): FeeStructure;
}