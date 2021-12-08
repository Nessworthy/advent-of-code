<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day08PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;

        foreach ($input->readLine() as $line) {
            [$signalPatterns, $outputValue] = explode(' | ', $line);
            $numbersToInputSignals = $this->determineDisplayKey(explode(' ', $signalPatterns));

            $translate = curry([$this, 'translate'], $numbersToInputSignals);

            $number = (int) implode(
                '',
                array_map(
                    $translate,
                    explode(
                        ' ',
                        $outputValue
                    )
                )
            );

            $output->writeLine($outputValue . ' -> ' . $number);

            $total += $number;
        }

        return $total;

    }

    public function translate(array $key, string $signal): int {
        $signalSplit = str_split($signal);
        sort($signalSplit);
        return $key[implode('', $signalSplit)];
    }

    private function determineDisplayKey(array $signals): array {

        $numberToSignals = [];

        while (count($numberToSignals) < 10) {

            foreach ($signals as $index => $signal) {

                $signalSplit = str_split($signal);
                sort($signalSplit);

                switch (strlen($signal)) {
                    case 2:
                        $numberToSignals[1] = $signalSplit;
                        unset($signals[$index]);
                        break;
                    case 3:
                        $numberToSignals[7] = $signalSplit;
                        unset($signals[$index]);
                        break;
                    case 4:
                        $numberToSignals[4] = $signalSplit;
                        unset($signals[$index]);
                        break;
                    case 7:
                        $numberToSignals[8] = $signalSplit;
                        unset($signals[$index]);
                        break;
                    case 5:
                        if (
                            !isset($numberToSignals[3])
                            && isset($numberToSignals[1])
                            && count(array_intersect($numberToSignals[1], $signalSplit)) === 2
                        ) {
                            $numberToSignals[3] = $signalSplit;
                            unset($signals[$index]);
                            break;
                        }

                        if (
                            !isset($numberToSignals[2], $numberToSignals[5])
                            && isset($numberToSignals[6])
                        ) {

                            if (
                                !isset($numberToSignals[5])
                                && (
                                    isset($numberToSignals[3], $numberToSignals[2])
                                    || count(array_intersect($numberToSignals[6], $signalSplit)) === 5
                                )
                            ) {
                                $numberToSignals[5] = $signalSplit;
                                unset($signals[$index]);
                                break;
                            }

                            if (
                                !isset($numberToSignals[2])
                                && (
                                    isset($numberToSignals[3], $numberToSignals[5])
                                    || count(array_intersect($numberToSignals[6], $signalSplit)) === 3
                                )
                            ) {
                                $numberToSignals[2] = $signalSplit;
                                unset($signals[$index]);
                                break;
                            }

                        }

                        break;
                    case 6:
                        if (
                            !isset($numberToSignals[6])
                            && isset($numberToSignals[1])
                            && count(array_intersect($numberToSignals[1], $signalSplit)) === 1
                        ) {
                            $numberToSignals[6] = $signalSplit;
                            unset($signals[$index]);
                            break;
                        }

                        if (
                            !isset($numberToSignals[9])
                            && isset($numberToSignals[3])
                            && count(array_intersect($numberToSignals[3], $signalSplit)) === 5
                        ) {
                            $numberToSignals[9] = $signalSplit;
                            unset($signals[$index]);
                            break;
                        }

                        if (
                            !isset($numberToSignals[0])
                        && isset($numberToSignals[6], $numberToSignals[9])
                        ) {
                            $numberToSignals[0] = $signalSplit;
                            unset($signals[$index]);
                        }
                }

            }
        }
        $return = [];
        foreach ($numberToSignals as $number => $signalSplit) {
            $return[implode('', $signalSplit)] = $number;
        }
        return $return;
    }
}
