<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\GroupByEmptyLine;

class Day6PartB implements Solution
{

    public function __construct(private GroupByEmptyLine $groupByEmptyLine)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $totalSharedAnswers = 0;
        foreach ($this->groupByEmptyLine->parse($input) as $group) {
            $totalSharedAnswers += count(array_intersect(...array_map('str_split', $group)));
        }
        $output->write((string) $totalSharedAnswers);
        return $totalSharedAnswers;
    }
}
