<?php

namespace Nessworthy\AoC2020\Grid;

use Generator;

class ConwayCube3D
{
    /**
     * Just some notes..
     *
     * A trick here is that although the grid is 3d, the puzzle starts on two planes.
     * You can say that the third plane is mirrored on either side, so we do not need to worry about -z.
     * Anything on z0 that reads on z-1 can be read on z+1, and operations etc. only need doing on
     * +z, and all counts can be done on +z and doubled (not forgetting to count z0 separately).
     */

    private array $grid = [];

    public function setActive(int $x, int $y, int $z): void {

        if ($z < 0) {
            return;
        }

        if (!isset($this->grid[$z])) {
            $this->grid[$z] = [];
        }

        if (!isset($this->grid[$z][$y])) {
            $this->grid[$z][$y] = [];
        }

        if (!isset($this->grid[$z][$y][$x])) {
            $this->grid[$z][$y][$x] = true;
        }
    }

    public function setInactive(int $x, int $y, int $z): void {

        if ($z < 0) {
            return;
        }

        if (isset($this->grid[$z][$y][$x])) {
            unset($this->grid[$z][$y][$x]);
        }

    }

    public function hasTwoOrThreeActiveNeighbours(int $x, int $y, int $z): bool {
        $active = 0;
        foreach ($this->getNeighbouringPoints($x, $y, $z) as [$nx, $ny, $nz]) {
            if ($this->isActive($nx, $ny, $nz)) {
                ++$active;
            }
        }
        return $active === 2 || $active === 3;
    }


    public function hasThreeActiveNeighbours(int $x, int $y, int $z): bool
    {
        $active = 0;
        foreach ($this->getNeighbouringPoints($x, $y, $z) as [$nx, $ny, $nz]) {
            if ($this->isActive($nx, $ny, $nz)) {
                ++$active;
            }
        }
        return $active === 3;
    }

    private function getNeighbouringPoints(int $x, int $y, int $z): Generator
    {
        for ($cz = $z - 1; $cz <= $z + 1; ++$cz) {
            for ($cy = $y - 1; $cy <= $y + 1; ++$cy) {
                for ($cx = $x - 1; $cx <= $x + 1; ++$cx) {
                    // If we need to optimize this later, then we can wash that pig then.
                    if ($cx === $x && $cy === $y && $cz === $z) {
                        continue;
                    }
                    yield [$cx, $cy, $cz];
                }
            }
        }
    }

    private function isActive(int $x, int $y, int $z): bool
    {
        return isset($this->grid[abs($z)][$y][$x]);
    }

    public function getNumberOfActivePoints(): int
    {
        $total = 0;
        foreach ($this->grid as $z => $square) {
            $amount = array_sum(array_map('count', $square));
            if ($z > 0) {
                // Mirror the total for -z
                $amount *= 2;
            }
            $total += $amount;
        }
        return $total;
    }

    public function getActivePoints(): Generator
    {
        foreach ($this->grid as $z => $square) {
            foreach ($square as $y => $col) {
                foreach ($col as $x => $unused) {
                    yield [$x, $y, $z];
                }
            }
        }
    }

    public function getInactivePoints(): Generator
    {
        // Tough one! We only care about inactive points neighbouring active ones, so let's only get those.
        $alreadyDone = [];
        foreach ($this->getActivePoints() as $activePoint) {
            foreach ($this->getNeighbouringPoints(...$activePoint) as $neighbouringPoint) {
                if ($this->isActive(...$neighbouringPoint)) {
                    continue;
                }
                if (in_array($neighbouringPoint, $alreadyDone, true)) {
                    continue;
                }
                $alreadyDone[] = $neighbouringPoint;
                yield $neighbouringPoint;
            }
        }
    }
}
