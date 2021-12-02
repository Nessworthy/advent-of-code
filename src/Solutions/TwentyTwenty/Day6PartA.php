<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\GroupByEmptyLine;

class Day6PartA implements Solution
{

    public function __construct(private GroupByEmptyLine $groupByEmptyLine)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $totalUniqueAnswers = 0;
        foreach ($this->groupByEmptyLine->parse($input) as $group) {
            $totalUniqueAnswers += count(array_unique(str_split(implode('', $group))));
        }
        $output->write((string) $totalUniqueAnswers);
        return $totalUniqueAnswers;
    }
}
