<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

use Exception;

final class BreakpointNotFoundException extends Exception 
{
    public function __construct() {
        parent::__construct('Breakpoint not found');
    }
}