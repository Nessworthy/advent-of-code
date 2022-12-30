<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\Rucksack;

class Rucksack {
    private string $contents;
    private array $left;
    private array $right;

    public function __construct(string $contents)
    {
        $this->contents = $contents;

        $size = strlen($contents) / 2;

        $this->left = str_split(substr($contents, 0, $size));
        $this->right = str_split(substr($contents, $size));
    }

    public function findOutOfPlaceItem(): Item {
        $same = array_intersect($this->left, $this->right);
        return new Item(array_pop($same));
    }

    public function getContents(): string
    {
        return $this->contents;
    }
}
