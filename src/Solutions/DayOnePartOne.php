<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;

class DayOnePartOne
{
    public function execute(Input $input, Output $output)
    {
        $numbers = [];
        while ($line = $input->readLine()) {

            $number = (int) $line;

            foreach ($numbers as $prevNumber) {
                if (($number + $prevNumber) === 0) {
                    $output->writeLine((string) $number);
                    $output->writeLine((string) $prevNumber);
                    $output->write((string) ($number * $prevNumber));
                    break 2;
                }
            }

            $numbers[] = (int) $line;
        }
    }

}
