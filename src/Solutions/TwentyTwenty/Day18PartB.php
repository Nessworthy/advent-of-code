<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day18PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;
        foreach ($input->readLine() as $line) {
            $total += $this->calculateLine($line, $output);
        }
        return $total;
    }

    private function calculateLine(string $line, Output $output): int
    {
        // Fuck it, let's throw regex at it.
        $bracketPattern = '#\((?<group>[^\(\)]+)\)#';

        // First, handle braces in order of highest priority.

        $bracketMatches = [];
        while (preg_match_all($bracketPattern, $line, $bracketMatches, PREG_OFFSET_CAPTURE)) {

            foreach (array_reverse($bracketMatches['group']) as [$bracketMatch, $bracketOffset]) {
                $output->writeLine($line);

                $bracketLength = strlen($bracketMatch);

                // $line = substr_replace($line, $bracketMatch, $bracketOffset - 1, $bracketLength + 2);
                $line = substr_replace(
                    $line,
                    $this->calculateEquation($bracketMatch, $bracketOffset, $output),
                    $bracketOffset - 1,
                    $bracketLength + 2
                );
            }

        }
        $result = $this->calculateEquation($line, 0, $output);
        return (int) $result;
    }

    private function calculateEquation(string $equationString, int $outputOffset, Output $output): string
    {
        $output->writeLine(str_repeat(' ', $outputOffset) . $equationString);
        $additionPattern = '#(?<full>(?<left>\b\d+) \+ (?<right>\d+\b))#';
        $multiplicationPattern = '#(?<full>(?<left>\b\d+) \* (?<right>\d+\b))#';

        $additionMatches = [];
        $multMatches = [];

        while (preg_match_all($additionPattern, $equationString, $additionMatches, PREG_OFFSET_CAPTURE)) {
            foreach ($additionMatches['full'] as $i => [$full, $additionOffset]) {
                $answer = ((int) $additionMatches['left'][$i][0]) + ((int) $additionMatches['right'][$i][0]);
                $equationString = substr_replace($equationString, (string) $answer, $additionOffset, strlen($full));
                $output->writeLine(str_repeat(' ', $outputOffset) . $equationString);
                continue 2;
            }
        }

        while (preg_match_all($multiplicationPattern, $equationString, $multMatches, PREG_OFFSET_CAPTURE)) {
            foreach ($multMatches['full'] as $i => [$full, $multOffset]) {
                $answer = ((int) $multMatches['left'][$i][0]) * ((int) $multMatches['right'][$i][0]);
                $equationString = substr_replace($equationString, (string) $answer, $multOffset, strlen($full));
                $output->writeLine(str_repeat(' ', $outputOffset) . $equationString);
                continue 2;
            }
        }

        return $equationString;
    }
}
