<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day10PartB implements Solution
{
    private const SCORE_MAP = [
        ')' => 1,
        ']' => 2,
        '}' => 3,
        '>' => 4
    ];

    private const OPEN = [
        '(' => true, '[' => true, '{' => true, '<' => true
    ];

    private const CLOSE = [
        ')' => true, ']' => true, '}' => true, '>' => true
    ];

    private const EXPECTED = [
        '[' => ']',
        '(' => ')',
        '{' => '}',
        '<' => '>'
    ];

    public function solve(Input $input, Output $output): int|string
    {
        $scores = [];

        foreach ($input->readLine() as $line) {
            $stack = [];
            foreach (str_split($line) as $current) {
                if (isset(self::OPEN[$current])) {
                    $stack[] = $current;
                    continue;
                }

                if (isset(self::CLOSE[$current])) {
                    $expected = array_pop($stack);
                    if (!$expected || self::EXPECTED[$expected] !== $current) {
                        continue 2;
                    }
                }
            }

            $score = 0;

            while ($open = array_pop($stack)) {
                $score  = (int) ($score * 5);
                $score += self::SCORE_MAP[self::EXPECTED[$open]];
            }
            $output->writeLine('Line score: ' . $score);
            $scores[] = $score;
        }

        sort($scores);

        return $scores[floor(count($scores) / 2)];
    }
}

