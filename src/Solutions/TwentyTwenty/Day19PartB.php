<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\RuleFactory;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\RuleRegistry;

class Day19PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $registry = new RuleRegistry();

        $factory = new RuleFactory($registry);

        $rulesEngineBuilt = false;
        $validSignals = 0;

        foreach ($input->readLine() as $line) {

            if ($line === "") {
                $rulesEngineBuilt = true;
                $output->writeLine('All rules registered!');
                continue;
            }

            if (!$rulesEngineBuilt) {

                if (str_starts_with($line, '8:')) {
                    $line = '8: 42 | 42 8';
                } elseif (str_starts_with($line, '11:')) {
                    $line = '11: 42 31 | 42 11 31';
                }

                // Step one - Build Rules.
                $matches = [];
                preg_match('#^(?<index>\d+): (?<rule>.+)$#', $line, $matches);

                $rule = $factory->createRuleFromString($matches['rule']);
                $registry->registerRule($rule, (int) $matches['index']);
            } else {
                // Step Two - Evaluate Rules
                $result = $registry->getRule(0)->matches($line);
                if ($result->matched() && in_array($line, $result->possibleMatches(), true)) {
                    $output->writeLine('Matched ' . $line);
                    ++$validSignals;
                }
            }
        }
        return $validSignals;
    }

}
