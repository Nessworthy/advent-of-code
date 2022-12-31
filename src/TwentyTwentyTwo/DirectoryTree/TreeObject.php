<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\DirectoryTree;

class TreeObject {
    private string $name;
    private int $parentId;
    private int $size;

    private array $children = [];
    private int $id;

    public function __construct(int $id, string $name, int $parentId, int $size)
    {
        $this->name = $name;
        $this->parentId = $parentId;
        $this->size = $size;
        $this->id = $id;
    }

    public function addChild(int $childId) {
        $this->children[] = $childId;
    }

    public function getChildren(): array {
        return $this->children;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getParent(): int
    {
        return $this->parentId;
    }

    public function getId(): int {
        return $this->id;
    }
}
