<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;

class Day1PartA implements Solution
{
    public function execute(Input $input, Output $output): void
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
                    break 2;
                }
            }

            $numbers[] = (int) $line;
        }
    }

}
