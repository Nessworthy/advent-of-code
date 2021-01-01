<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\Validator\TrainTicketMachine;

class Day16PartA implements Solution
{
    public function execute(Input $input, Output $output): int|string
    {
        $rules = [];
        $readRules = false;
        $readYourTicket = false;
        $machine = null;
        $invalidValues = 0;

        foreach ($input->readLine() as $line) {
            if (!$readRules) {
                // Rules first.
                if ($line === '') {
                    $readRules = true;
                    $machine = new TrainTicketMachine($rules);
                    continue;
                }
                $line = explode(': ', $line);
                $rule = $line[0];
                $ranges = explode(' or ', $line[1]);
                $rules[$rule] = [];
                foreach ($ranges as $range) {
                    [$min, $max] = explode('-', $range);
                    $rules[$rule][] = [(int)$min, (int)$max];
                }
            } elseif (!$readYourTicket) {
                if ($line === '') {
                    $readYourTicket = true;
                    continue;
                }
                if ($line === 'your ticket:') {
                    continue;
                }
                continue;
            } else {
                if ($line === 'nearby tickets:') {
                    continue;
                }
                $ticketValues = [];
                foreach (explode(',', $line) as $value) {
                    $ticketValues[] = (int) $value;
                }
                foreach ($machine->getInvalidValues($ticketValues) as $value) {
                    $invalidValues += $value;
                }
            }
        }
        return $invalidValues;
    }
}
