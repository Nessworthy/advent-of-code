<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\NumberRange\NumberRange;
use Nessworthy\AoC\Solutions\Solution;

class Day05PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $ranges = [];
        foreach ($input->readLine() as $line) {
            if (empty($line)) {
                break;
            }

            $range = new NumberRange(...array_map('toInt', explode('-', $line)));

            $ranges[] = $range;
        }

        usort($ranges, static fn ($a, $b) => $a->from() <=> $b->from() ?: $a->to() <=> $b->to());

        $output->writeLine('Sorted!');

        $totalFresh = 0;

        /** @var NumberRange $currentRange */
        $currentRange = current($ranges);
        $max = count($ranges);
        while ($currentRange) {
            $currentPosition = key($ranges);

            $output->writeLine(sprintf('Range %s (%d/%d)', $currentRange, $currentPosition + 1, $max));

            $nextPosition = $currentPosition + 1;
            while (isset($ranges[$nextPosition])) {
                $nextRange = $ranges[$nextPosition];
                if ($currentRange->canCleanlyMergeWith($nextRange)) {
                    $currentRange = $currentRange->mergeWith($nextRange);
                    $output->writeLine(sprintf('  ... merged with %s to form %s', $nextRange, $currentRange));
                    unset($ranges[$nextPosition]);
                    $nextPosition++;
                    continue;
                }
                break;
            }

            $total = $currentRange->to() - $currentRange->from() + 1;
            $output->writeLine(sprintf('  Total: %d', $total));
            $output->writeLine('');

            $totalFresh += $total;

            $currentRange = next($ranges);
        }

        return $totalFresh;
    }
}
