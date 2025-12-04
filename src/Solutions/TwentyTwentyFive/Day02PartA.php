<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\NumberRange\NumberRange;
use Nessworthy\AoC\Solutions\Solution;

class Day02PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $invalidIdSum = 0;
        foreach ($input->readUntil(',') as $rangeString) {
            [$startStr, $endStr] = explode('-', $rangeString);
            [$originalStart, $originalEnd] = array_map('toInt', explode('-', $rangeString));
            [$start, $end] = [$originalStart, $originalEnd];

            // Normalize start number to closest even-character number.
            if (!isEven(strlen($startStr))) {
                $start =  10 ** strlen($startStr);
            }
            // Same with end number, except if it is too low, we can just skip.
            if (!isEven(strlen($endStr))) {
                if (strlen($endStr) < 3) {
                    $output->writeLine(sprintf('Skipping %s: end number too low to matter', $rangeString));
                    continue;
                }
                $end = 10 ** (strlen($endStr) - 1) - 1;
            }
            $originalRange = new NumberRange($originalStart, $originalEnd);
            $range = new NumberRange($start, $end);
            if ($start > $end || !$range->canCleanlyMergeWith($originalRange)) {
                $output->writeLine(sprintf('Skipping %s: Number range would have no matches.', $rangeString));
                continue;
            }

            // We halve both ends and this becomes the mirrored number range.
            $halfRange = new NumberRange(
                (int) substr((string) $start, 0, (int) (strlen((string) $start) / 2)),
                (int) substr((string) $end, 0, (int) (strlen((string) $end) / 2))
            );
            // $output->writeLine(sprintf('%s: Becomes %s', $rangeString, $halfRange));

            $subtotal = 0;
            foreach ($halfRange->iterate() as $number) {
                $actualNumber = (int) str_repeat((string) $number, 2);
                if (!$originalRange->isInclusivelyBetween($actualNumber)) {
                    continue;
                }
                $output->writeLine(sprintf('%s: Includes %s', $rangeString, $actualNumber));
                $subtotal += $actualNumber;
            }
            // $output->writeLine(sprintf('%s: Adds %s', $rangeString, $subtotal));
            $invalidIdSum += $subtotal;
        }
        return $invalidIdSum;
    }
}
