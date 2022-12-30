<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\Rucksack\Rucksack;
use Nessworthy\AoC\TwentyTwentyTwo\Rucksack\RucksackGroup;

class Day03PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $value = 0;

        $groupSize = 3;
        $currentGroup = [];

        foreach ($input->readLine() as $line) {

            $currentGroup[] = new Rucksack($line);

            if (count($currentGroup) >= $groupSize) {
                $group = new RucksackGroup(...$currentGroup);
                $item = $group->findSharedItem();
                $value += $item->getValue();
                $output->writeLine('Group: ' . $currentGroup[0]->getContents() . ' / ' . $currentGroup[1]->getContents() . ' / ' . $currentGroup[2]->getContents());
                $output->writeLine('Identified item: ' . $item->getItem() . ' (' . $item->getValue() . ')');
                $currentGroup = [];
            }
        }

        return $value;
    }
}
