<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\LineParser\GroupByEmptyLine;

class Day6PartA implements Solution
{

    public function __construct(private GroupByEmptyLine $groupByEmptyLine)
    {
    }

    public function execute(Input $input, Output $output): int|string
    {
        $totalUniqueAnswers = 0;
        foreach ($this->groupByEmptyLine->parse($input) as $group) {
            $totalUniqueAnswers += count(array_unique(str_split(implode('', $group))));
        }
        $output->write((string) $totalUniqueAnswers);
        return $totalUniqueAnswers;
    }
}
