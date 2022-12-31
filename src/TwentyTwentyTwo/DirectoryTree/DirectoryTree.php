<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\DirectoryTree;

use Generator;

class DirectoryTree {
    /**
     * @var TreeObject[]
     */
    private array $nodes = [];

    private int $currentId = 0;
    private int $newId = 1;

    private array $cachedNodeSizes = [];

    public function __construct()
    {
        $this->nodes[0] = new TreeObject(0, '/', 0, 0);
    }

    public function createDirectory(string $name): void {
        $this->nodes[] = new TreeObject($this->newId, $name, $this->currentId, 0);
        $this->nodes[$this->currentId]->addChild($this->newId);
        ++$this->newId;
    }

    public function createFile(string $name, int $size): void {
        $this->nodes[] = new TreeObject($this->newId, $name, $this->currentId, $size);
        $this->nodes[$this->currentId]->addChild($this->newId);
        ++$this->newId;
    }

    public function changeDirectory(string $toName): void {
        foreach ($this->nodes[$this->currentId]->getChildren() as $childId) {
            if ($this->nodes[$childId]->getName() === $toName) {
                $this->changeDirectoryToId($childId);
                return;
            }
        }
        var_dump($this->nodes);
        var_dump($this->currentId);
        throw new \RuntimeException('No directory found called ' . $toName);
    }

    public function listAllFiles(): Generator {
        foreach ($this->nodes as $node) {
            if ($node->getSize() === 0) {
                continue;
            }
            yield $node;
        }
    }

    public function listAllDirectories(): Generator {
        foreach ($this->nodes as $node) {
            if ($node->getSize() !== 0) {
                continue;
            }
            yield $node;
        }
    }


    private function changeDirectoryToId(int $id): void {
        $this->currentId = $id;
    }

    public function traverseUpDirectory(): void {
        $this->changeDirectoryToId($this->nodes[$this->currentId]->getParent());
    }

    public function changeDirectoryToRoot(): void {
        $this->changeDirectoryToId(0);
    }

    public function getObjectSize(int $id): int {
        if (isset($this->cachedNodeSizes[$id])) {
            return $this->cachedNodeSizes[$id];
        }
        $size = $this->nodes[$id]->getSize();
        foreach ($this->nodes[$id]->getChildren() as $childId) {
            $size += $this->getObjectSize($childId);
        }
        $this->cachedNodeSizes[$id] = $size;
        return $size;
    }
}
