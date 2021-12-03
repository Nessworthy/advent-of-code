<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser;

use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule\MatchesCharacter;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule\MatchesOneOfRules;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule\MatchesSubRulesFromRegistry;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule\Rule;

class RuleFactory
{
    private RuleRegistry $ruleRegistry;

    public function __construct(RuleRegistry $ruleRegistry)
    {
        $this->ruleRegistry = $ruleRegistry;
    }

    public function createRuleFromString(string $ruleString): Rule
    {
        $matches = [];
        if (preg_match('#^"(.)"$#', $ruleString, $matches)) {
            return new MatchesCharacter($matches[1]);
        }

        $parts = explode(' | ', $ruleString);

        if (count($parts) === 1) {
            return new MatchesSubRulesFromRegistry(
                $this->ruleRegistry,
                ...array_map('toInt', explode(' ', $parts[0]))
            );
        }

        $rules = [];

        foreach ($parts as $part) {
            $rules[] = new MatchesSubRulesFromRegistry(
                $this->ruleRegistry,
                ...array_map('toInt', explode(' ', $part))
            );
        }

        return new MatchesOneOfRules(...$rules);
    }
}
