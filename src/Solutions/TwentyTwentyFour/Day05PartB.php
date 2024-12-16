<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day05PartB implements Solution {

    /**
     * @param int[] $sequence
     * @param int[][] $rules
     * @return bool|array
     */
    private function test(array $sequence, array $rules): bool | array {
        $mines = [];
        foreach ($sequence as $position => $number) {
            if (isset($mines[$number])) {
                return [
                    'failedAt' => ['index' => $position, 'number' => $number],
                    'source' => ['index' => $mines[$number][0], 'number' => $mines[$number][1]]];
            }
            if (isset($rules[$number])) {
                foreach ($rules[$number] as $mine => $_) {
                    if (!isset($mines[$mine])) {
                        $mines[$mine] = [$position, $number];
                    }
                }
            }
        }

        return true;
    }

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
                $sequenceIndex = $i - $offset;
                $result = $this->test($sequence, $rules);

                if ($result === true) {
                    $output->writeLine('Sequence ' . ($sequenceIndex) . ' success!');
                } else {
                    $output->writeLine('Sequence ' . ($sequenceIndex) . ' failed! (' . $result['failedAt']['number'] . ':' . $result['failedAt']['index'] . ' > ' . $result['source']['number'] . ':'. $result['source']['index'] . ')');
                    for (
                        $nextSequence = $sequence, $attempts = 1, $maxAttempts = 20;
                        $attempts <= $maxAttempts;
                        $attempts ++
                    ) {
                        $tempSequence = array_merge(
                            array_slice(
                                $nextSequence,
                                0,
                                $result['source']['index']
                            ),
                            [$result['failedAt']['number']],
                            array_slice(
                                $nextSequence,
                                $result['source']['index'],
                                $result['failedAt']['index'] - $result['source']['index'],
                            ),
                            array_slice($nextSequence, $result['failedAt']['index'] + 1)
                        );
                        $nextSequence = $tempSequence;
                        $result = $this->test($nextSequence, $rules);
                        if ($result === true) {
                            $output->writeLine(implode(',', $nextSequence) . ' - Fixed after ' . $attempts . ' attempts!');
                            $score += $nextSequence[(count($nextSequence) - 1) / 2];
                            break;
                        }
                        $output->writeLine(implode(',', $tempSequence) . ' - ' . $result['failedAt']['number'] . ':' . $result['failedAt']['index'] . ' > ' . $result['source']['number'] . ':'. $result['source']['index']);
                    }
                    if ($maxAttempts === $attempts) {
                        $output->writeLine('Too many attempts for sequence. Bailing...');
                    }
                }

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

        // 2300 - too low
        return $score;
    }
}
