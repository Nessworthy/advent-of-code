<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\LineParser\PasswordPolicy;

class DayTwoPartOne implements Solution
{

    public function __construct(private PasswordPolicy $passwordPolicyParser)
    {
    }

    public function execute(Input $input, Output $output): void
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
    }

}
