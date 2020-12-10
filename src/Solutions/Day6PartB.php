<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\LineParser\GroupByEmptyLine;

class Day6PartB implements Solution
{

    public function __construct(private GroupByEmptyLine $groupByEmptyLine)
    {
    }

    public function execute(Input $input, Output $output): int|string
    {
        $totalSharedAnswers = 0;
        foreach ($this->groupByEmptyLine->parse($input) as $group) {
            $totalSharedAnswers += count(array_intersect(...array_map('str_split', $group)));
        }
        $output->write((string) $totalSharedAnswers);
        return $totalSharedAnswers;
    }
}
