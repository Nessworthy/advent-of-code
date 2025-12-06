<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\NumberRange\NumberRange;
use Nessworthy\AoC\Solutions\Solution;

class Day05PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $byLowest = [];
        foreach ($input->readLine() as $line) {
            if (empty($line)) {
                break;
            }
            
            $range = new NumberRange(...array_map('toInt', explode('-', $line)));

            if (!isset($byLowest[$range->from()])) {
                $byLowest[$range->from()] = [];
            }
            $byLowest[$range->from()][] = $range;
        }
        ksort($byLowest);

        // Collect all inputs
        $ingredients = [];
        foreach ($input->readLine() as $line) {
            $ingredients[] = (int) $line;
        }
        sort($ingredients);

        $fresh = 0;
        $ranges = current($byLowest);

        $output->writeLine('Lowest range is ' . key($byLowest));

        foreach ($ingredients as $ingredientId) {
            $output->writeLine('Checking ' . $ingredientId);

            while ($ranges) {
                $rangeMin = key($byLowest);

                if ($rangeMin > $ingredientId) {
                    // Current ingredient ID is too low, advance ingredients until within range.
                    $output->writeLine('  Stale: Too low');
                    continue 2;
                }

                /**
                 * @var $range NumberRange
                 */
                foreach ($ranges as $range) {
                    $output->writeLine('  ... against ' . $range->__toString());
                    if ($range->isInclusivelyBetween($ingredientId)) {
                        // Fresh! Increment stat and move to next ingredient.
                        $output->writeLine('  ... fresh!');
                        $fresh++;
                        continue 3;
                    }
                }
                // Out of range, move to next highest range.
                $ranges = next($byLowest);
                $output->writeLine('  Increasing range to ' . (key($byLowest) ?? '(end)'));
            }
            $output->writeLine('  Stale: Not in range.');
        }

        return $fresh;
    }
}

// 56 not right