<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result;

/**
 * Originally, Part A only had the concept of whether something matched or not,
 * with successful matches also providing the location of the next pointer to allow for a variable number
 * of characters to be consumed.
 *
 * Part B threw a massive spanner in the works by simply showing that something like:
 * 0: 1 | 1 2
 * 1: A
 * 2: B
 *
 * AB
 *
 * Would fail, due to the rules matching "A" of "AB" then failing because the matched pointer
 * did not reach the end of the input. So I had to add the possibility that OR choices could both be correct
 * in their own scope, and leave it to parent rules to check all possible matches from their scopes.
 *
 * Ultimately, it would then fall back to the top level checking all possible matches against the original string
 * to validate that at least one of the valid rule paths consumed the full string.
 *
 * To do this, successful matches needed to start passing what they were able to match on as an array of strings.
 * And then other rules could build off of those to either ultimately fail or match with their rules for each potential.
 *
 * It's also 00:26 and I'm absolutely wrecked from a day of training and then a WoW raid, so this may not make sense.
 */
interface Result {
    public function matched(): bool;
    public function possibleMatches(): array;
}
