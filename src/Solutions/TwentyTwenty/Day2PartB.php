<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\PasswordPolicy;

class Day2PartB implements Solution
{

    public function __construct(private PasswordPolicy $passwordPolicyParser)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $correct = 0;
        foreach ($input->readLine() as $line) {
            $entry = $this->passwordPolicyParser->parse($line);

            if (($entry->string[$entry->min - 1] === $entry->char) xor ($entry->string[$entry->max - 1] === $entry->char)) {
                ++$correct;
            }
        }

        $output->write((string) $correct);
        return $correct;
    }

}
