<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

use Exception;

final class InvalidLoanAmountException extends Exception 
{
    public function __construct() {
        parent::__construct('The loan amount must be between 1000 or 20000');
    }
}