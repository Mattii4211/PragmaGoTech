<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

use Exception;

final class BreakpointAlreadyExsistException extends Exception 
{
    public function __construct() {
        parent::__construct('Breakpoint already exsist');
    }
}