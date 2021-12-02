<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use RuntimeException;

class Day9PartA implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $max = 25;
        $bucket = [];

        foreach ($input->readLine() as $line) {
            $number = (int) $line;

            if (count($bucket) < $max) {
                // Fill up the bucket.
                $bucket[] = $number;
                $output->writeLine(sprintf('Adding %d to the bucket', $number));
                continue;
            }

            foreach ($bucket as $index => $candidate) {
                if ($candidate >= $number) {
                    continue;
                }
                $target = $number - $candidate;
                if ($target === $candidate) {
                    continue;
                }
                if (in_array($target, array_slice($bucket, $index), true)) {
                    $output->writeLine(sprintf('%d + %d = %d', $candidate, $target, $number));
                    $bucket[] = $number;
                    array_shift($bucket);
                    continue 2;
                }
            }
            $output->writeLine(sprintf('No solution can be found for %d', $number));
            return $number;
        }
        throw new RuntimeException('Answer not found.');
    }
}
