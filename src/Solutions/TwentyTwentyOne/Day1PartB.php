<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Generator;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day1PartB implements Solution
{
    private const READS_PER_GROUP = 3;

    private function groupReadings(Generator $generator): Generator {
        foreach ($generator as $line) {
            $reading = (int) $line;

            $group[] = $reading;

            if (count($group) < self::READS_PER_GROUP) {
                continue;
            }

            yield array_sum($group);
            array_shift($group);
        }
    }

    public function solve(Input $input, Output $output): int|string
    {
        /**
         * All we need to do here is add a middle layer between
         * the raw input and the comparisons. groupReadings takes
         * a generator, groups every 3 values together, and spits
         * out the sum.
         */
        return generator_reduce(
            $this->groupReadings($input->readLine()),
            static function($carry, $current) {
                $current = (int) $current;
                [$increments, $previous] = $carry;
                if ($current > $previous && !is_null($previous)) {
                    ++$increments;
                }
                return [$increments, $current];
            },
            [0, null]
        )[0];
    }
}
