<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule;

use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\NoMatch;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\Result;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\RuleMatch;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\RuleRegistry;

class MatchesOneOfRules implements Rule
{
    /**
     * @var Rule[]
     */
    private array $rules;

    public function __construct(Rule ...$rules)
    {
        $this->rules = $rules;
    }

    public function matches(string $string): Result
    {
        $groups = [];
        foreach ($this->rules as $rule) {
            $result = $rule->matches($string);
            if ($result->matched()) {
                foreach ($result->possibleMatches() as $group) {
                    $groups[] = $group;
                }
            }
        }

        if ($groups) {
            return new RuleMatch($groups);
        }

        return new NoMatch;
    }

}
