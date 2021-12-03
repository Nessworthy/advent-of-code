<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule;

use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\NoMatch;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\Result;
use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\RuleMatch;

class MatchesCharacter implements Rule
{
    private string $character;

    public function __construct(string $character)
    {
        $this->character = $character;
    }

    public function matches(string $string): Result
    {
        if ($string === "") {
            return new NoMatch;
        }
        return $string[0] === $this->character
            ? new RuleMatch([$this->character])
            : new NoMatch;
    }
}
