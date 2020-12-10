<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\LineParser\PasswordPolicy;

class Day2PartB implements Solution
{

    public function __construct(private PasswordPolicy $passwordPolicyParser)
    {
    }

    public function execute(Input $input, Output $output): int|string
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
