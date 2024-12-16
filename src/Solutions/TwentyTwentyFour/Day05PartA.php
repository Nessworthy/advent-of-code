<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day05PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $rules = [];
        $gen = $input->readLine();
        $process = false;
        $offset = 0;
        $score = 0;
        foreach ($gen as $i => $line) {
            if ($process) {
                $sequence = array_map('toInt', explode(',', $line));
                $mines = [];
                foreach ($sequence as $number) {
                    if (isset($mines[$number])) {
                        $output->writeLine('Sequence ' . ($i - $offset) . ' failed because of ' . $number . ' occurring after ' . $mines[$number]);
                        continue 2;
                    }
                    if (isset($rules[$number])) {
                        foreach($rules[$number] as $mine => $_) {
                            $mines[$mine] = $number;
                        }
                    }
                }
                $output->writeLine('Sequence ' . ($i - $offset) . ' success!');
                $score += $sequence[(count($sequence) - 1) / 2];
            } else if ($line === '') {
                $offset = $i;
                $process = true;
            } else {
                $pages = array_map('toInt', explode('|', $line, 2));

                if (!isset($rules[$pages[1]])) {
                    $rules[$pages[1]] = [];
                }
                $rules[$pages[1]][$pages[0]] = true;
            }
        }


        return $score;
    }
}
