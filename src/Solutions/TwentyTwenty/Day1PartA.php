<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use RuntimeException;

class Day1PartA implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $output->write('Hello world!');
        $numbers = [];
        foreach ($input->readLine() as $line) {
            $number = (int) $line;

            foreach ($numbers as $prevNumber) {
                if (($number + $prevNumber) === 2020) {
                    $output->writeLine((string) $number);
                    $output->writeLine((string) $prevNumber);
                    $output->writeLine((string) ($number * $prevNumber));
                    return $number * $prevNumber;
                }
            }

            $numbers[] = (int) $line;
        }
        throw new RuntimeException('Answer not found.');
    }

}
