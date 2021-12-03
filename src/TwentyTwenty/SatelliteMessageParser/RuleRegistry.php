<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser;

use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule\Rule;

class RuleRegistry
{
    private array $rules = [];

    public function registerRule(Rule $rule, int $index): void
    {
        $this->rules[$index] = $rule;
    }

    public function hasRule(int $index): bool {
        return isset($this->rules[$index]);
    }

    public function getRule(int $index): Rule
    {
        # echo "Requested: #" . $index . "\n";
        return $this->rules[$index];
    }
}
