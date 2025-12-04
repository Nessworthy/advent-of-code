<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\NumberRange\NumberRange;
use Nessworthy\AoC\Solutions\Solution;

class Day02PartB implements Solution {

    private function normalizeRange(NumberRange $originalRange, int $digits, Output $output): NumberRange|null {
        $startStr = (string) $originalRange->from();
        $startStrLen = strlen($startStr);

        $endStr = (string) $originalRange->to();
        $endStrLen = strlen($endStr);

        $start = $originalRange->from();
        $end = $originalRange->to();

        if ($startStrLen % $digits !== 0) {
            $start = 10 ** ($startStrLen - 1 + $digits - $startStrLen % $digits);
        }

        if ($endStrLen % $digits !== 0) {
            $end = 10 ** ($endStrLen - ($endStrLen % $digits)) - 1;
        }

        $range = new NumberRange($start, $end);
        $output->writeLine($originalRange . ': Narrowed to ' . $range . ' for ' . $digits . ' digit repetition.');
        if ($start > $end || !$range->inclusivelyFitsWithin($originalRange)) {
            $output->writeLine(sprintf('%s: Skipped - Number range would have no matches.', $originalRange));
            return null;
        }

        return $range;
    }

    private function splitRange(NumberRange $range): \Generator {
        $fromDigits = strlen((string) $range->from());
        $toDigits = strlen((string) $range->to());

        for ($e = $fromDigits; $e <= $toDigits; $e++) {
            yield new NumberRange(
                max($range->from(), 10 ** ($e - 1)),
                min($range->to(), 10 ** $e - 1),
            );
        }
    }

    public function solve(Input $input, Output $output): int|string
    {
        $invalidIdSum = 0;
        foreach ($input->readUntil(',') as $rangeString) {
            [$startStr, $endStr] = explode('-', $rangeString);
            [$originalStart, $originalEnd] = array_map('toInt', explode('-', $rangeString));
            [$start, $end] = [$originalStart, $originalEnd];

            $matches = [];
            $digitCount = floor(strlen($endStr) / 2);
            $originalRange = new NumberRange($start, $end);
            for ($group = 1; $group <= $digitCount; $group++) {
                $patternRange = $this->normalizeRange($originalRange, $group, $output);
                if (!$patternRange) {
                    continue;
                }

                // Split the overall range into digit-based sub-ranges.
                foreach ($this->splitRange($patternRange) as $subRange) {
                    $output->writeLine(sprintf('%s: Iterating over sub-range %s', $originalRange, $subRange));

                    // Does the group fit into this sub range?
                    $length = strlen((string) $subRange->from());
                    if ($length % $group !== 0) {
                        $output->writeLine(sprintf('%s: Ignoring as it does not divide evenly by %d', $originalRange, $group));
                        continue;
                    }

                    // If the digit count is 1, skip - rules say it must appear at least TWICE.
                    if ($length === 1) {
                        $output->writeLine(sprintf('%s: Skipping sub-range %s as it\'s too small.', $originalRange, $subRange));
                        continue;
                    }

                    // Create the segment.
                    $segmentRange = new NumberRange(
                        (int) substr((string) $subRange->from(), 0, $group),
                        (int) substr((string) $subRange->to(), 0, $group),
                    );

                    foreach ($segmentRange->iterate() as $numberBase) {
                        $actualNumber = (int) str_repeat((string) $numberBase, $length / $group);
                        $output->writeLine(sprintf('%s: %s -> %s', $originalRange, $numberBase, $actualNumber));
                        if (!$originalRange->isInclusivelyBetween($actualNumber)) {
                            continue;
                        }
                        $output->writeLine(sprintf('%s: %d fits in range %s!', $originalRange, $actualNumber, $originalRange));
                        $matches[$actualNumber] = true;
                    }
                }

            }
            $output->writeLine(
                sprintf(
                    'Matches for %s: %s',
                    $originalRange,
                    implode(', ', array_keys($matches))
                )
            );
            $invalidIdSum += array_sum(array_keys($matches));
        }
        return $invalidIdSum;
    }
}
// 46769308530 too high
// 46769308485
