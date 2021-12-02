<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\PasswordPolicy;

class Day2PartA implements Solution
{

    public function __construct(private PasswordPolicy $passwordPolicyParser)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $correct = 0;
        foreach ($input->readLine() as $line) {
            $entry = $this->passwordPolicyParser->parse($line);

            $split = str_split($entry->string);
            $counts = array_count_values($split);

            if (between_inclusive(($counts[$entry->char] ?? 0), $entry->min, $entry->max)) {
                ++$correct;
            }
        }

        $output->write((string) $correct);
        return $correct;
    }

}
