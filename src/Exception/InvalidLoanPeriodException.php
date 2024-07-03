<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

use Exception;

final class InvalidLoanPeriodException extends Exception 
{
    public function __construct() {
        parent::__construct('Invalid term value (only 12 or 24)');
    }
}