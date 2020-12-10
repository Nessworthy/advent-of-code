<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\LineParser\PassportScanner;
use Nessworthy\AoC2020\Validator\PassportChecker;

class Day4PartB implements Solution
{
    public function __construct(private PassportScanner $passportScanner, private PassportChecker $passportChecker)
    {
    }

    public function execute(Input $input, Output $output): int|string
    {
        $valid = 0;
        foreach ($this->passportScanner->scanInput($input) as $passport) {
            $valid += $this->passportChecker->validate($passport) ? 1 : 0;
        }
        $output->write((string) $valid);
        return $valid;
    }
}
