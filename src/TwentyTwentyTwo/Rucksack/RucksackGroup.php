<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\Rucksack;

class RucksackGroup {
    private array $rucksacks;

    public function __construct(
        Rucksack ...$rucksacks
    ) {
        $this->rucksacks = $rucksacks;
    }

    public function findSharedItem(): Item {

        $shared = array_intersect(...array_map(static fn(Rucksack $rucksack) => str_split($rucksack->getContents()), $this->rucksacks));

        $letter = array_pop($shared);

        return new Item($letter);
    }
}
