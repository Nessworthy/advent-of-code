<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day10PartA implements Solution
{

    private const SCORE_MAP = [
        ')' => 3,
        ']' => 57,
        '}' => 1197,
        '>' => 25137
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
        $score = 0;

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
                        $score += self::SCORE_MAP[$current];
                        continue 2;
                    }
                }
            }
        }

        return $score;
    }
}

