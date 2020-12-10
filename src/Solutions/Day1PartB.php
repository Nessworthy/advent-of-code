<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use RuntimeException;

class Day1PartB implements Solution
{
    public function execute(Input $input, Output $output): int|string
    {
        $output->write('Hello world!');
        $numbers = [];
        foreach ($input->readLine() as $line) {
            $number = (int) $line;

            foreach ($numbers as $i => $secondNumber) {
                if (($number + $secondNumber) >= 2020) {
                    continue;
                }
                foreach (array_slice($numbers, $i) as $thirdNumber) {
                    if (($number + $secondNumber + $thirdNumber) === 2020) {
                        $output->writeLine((string)$number);
                        $output->writeLine((string)$secondNumber);
                        $output->writeLine((string)$thirdNumber);
                        $output->writeLine((string)($number * $secondNumber * $thirdNumber));
                        return $number * $secondNumber * $thirdNumber;
                    }
                }
            }

            $numbers[] = (int) $line;
        }
        throw new RuntimeException('Answer not found.');
    }

}
