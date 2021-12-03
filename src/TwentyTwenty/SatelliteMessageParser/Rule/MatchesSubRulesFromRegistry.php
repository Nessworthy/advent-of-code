<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule;

use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\NoMatch;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\Result;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\RuleMatch;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\RuleRegistry;

class MatchesSubRulesFromRegistry implements Rule
{
    /**
     * @var int[]
     */
    private array $rules;
    private RuleRegistry $ruleRegistry;

    public function __construct(RuleRegistry $ruleRegistry, int ...$ruleIndexes)
    {
        $this->rules = $ruleIndexes;
        $this->ruleRegistry = $ruleRegistry;
    }

    public function matches(string $string): Result
    {
        $result = $this->ruleRegistry->getRule($this->rules[0])->matches(substr($string, 0));
        $matches = $result->possibleMatches();

        foreach (array_slice($this->rules, 1) as $rule) {
            $nextMatches = [];
            foreach ($matches as $possibleMatch) {
                $matchPointer = strlen($possibleMatch);

                $result = $this->ruleRegistry->getRule($rule)->matches(substr($string, $matchPointer));

                foreach ($result->possibleMatches() as $possibleNextMatch) {
                    $nextMatches[] = $possibleMatch . $possibleNextMatch;
                }
            }
            $matches = $nextMatches;
        }

        if ($matches) {
            return new RuleMatch($matches);
        }

        return new NoMatch;
    }
}
