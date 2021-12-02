<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\PassportScanner;

class Day4PartA implements Solution
{

    /**
     * @var PassportScanner
     */
    private PassportScanner $passportScanner;

    public function __construct(PassportScanner $passportScanner)
    {
        $this->passportScanner = $passportScanner;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $requiredFields = ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid']; // 'cid'
        sort($requiredFields);
        $valid = 0;
        foreach ($this->passportScanner->scanInput($input) as $passport) {
            $fieldKeys = array_keys($passport);
            if (array_intersect($requiredFields, $fieldKeys) === $requiredFields) {
                ++$valid;
            }
        }
        $output->write((string) $valid);
        return $valid;
    }
}
