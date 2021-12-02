<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\PassportScanner;
use Nessworthy\AoC\TwentyTwenty\Validator\PassportChecker;

class Day4PartB implements Solution
{
    public function __construct(private PassportScanner $passportScanner, private PassportChecker $passportChecker)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $valid = 0;
        foreach ($this->passportScanner->scanInput($input) as $passport) {
            $valid += $this->passportChecker->validate($passport) ? 1 : 0;
        }
        $output->write((string) $valid);
        return $valid;
    }
}
