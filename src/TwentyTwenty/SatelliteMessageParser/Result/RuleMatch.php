<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result;

class RuleMatch implements Result {
    /**
     * @var string[]
     */
    private array $groups;

    public function __construct(array $groups)
    {
        $this->groups = $groups;
    }

    public function matched(): bool
    {
        return true;
    }

    public function possibleMatches(): array
    {
        return $this->groups;
    }
}
