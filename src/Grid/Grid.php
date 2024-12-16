<?php declare(strict_types=1);

namespace Nessworthy\AoC\Grid;

use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Coordinates\Point2DHelper;

class Grid {
    /**
     * [$y][$x]
     */
    private array $gridByRows;

    /**
     * [$x][$y]
     */
    private array $gridByColumns = [];

    private int $width = 0;
    private int $height;

    public function __construct(array $grid)
    {
        $this->gridByRows = $grid;

        foreach ($grid as $y => $row) {
            if ($this->width < count($row)) {
                $this->width = count($row);
            }
            foreach ($row as $x => $value) {
                if (!isset($this->gridByColumns[$y])) {
                    $this->gridByColumns[$x] = [];
                }
                $this->gridByColumns[$x][$y] = $value;
            }
        }

        $this->height = count($this->gridByRows);
    }

    public function getRow(int $y): array {
        return $this->gridByRows[$y];
    }

    public function getRows(): \Generator {
        for ($i = 0; $i < $this->getHeight(); $i++) {
            yield $i => $this->getRow($i);
        }
    }

    public function getColumn(int $x): array {
        return $this->gridByColumns[$x];
    }

    public function getByPoint(Point2D $point) {
        return $this->gridByRows[$point->y()][$point->x()];
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    public function getSlice(Point2D $point, GridDirection $direction, int $length) {
        $collected = [];
        $currentPoint = $point;
        while ($length > 0) {
            if (!$this->isPointInGrid($currentPoint)) {
                return $collected;
            }
            $collected[] = $this->getByPoint($currentPoint);
            $currentPoint = Point2DHelper::bump($currentPoint, $direction);
            $length--;
        }
        return $collected;
    }

    public function isPointInGrid(Point2D $point): bool {
        return between_inclusive($point->x(), 0, $this->getWidth() - 1) && between_inclusive($point->y(), 0, $this->getHeight() - 1);
    }

    public function getSliceFromCenter(Point2D $point, $radius = 1): Grid {
        $slice = [];

        $fromX = max($point->x() - $radius, 0);
        $fromY = max($point->y() - $radius, 0);
        $toX = min($point->x() + $radius, $this->getWidth() - $radius);
        $toY = min($point->y() + $radius, $this->getHeight() - $radius);

        for ($y = $fromY; $y <= $toY; $y++) {
            $slice[] = array_slice($this->gridByRows[$y], $fromX, 1 + $toX - $fromX);
        }

        return new Grid($slice);
    }

    public function traverseFromTopLeft(): \Generator {
        foreach ($this->getRows() as $y => $row) {
            foreach ($row as $x => $value) {
                yield new Point2D($x, $y) => $value;
            }
        }
    }

    public function findFirst(string|int $symbol): Point2D | null {
        foreach ($this->traverseFromTopLeft() as $point => $value) {
            if ($symbol === $value) {
                return $point;
            }
        }
        return null;
    }

    public function setValueAt(Point2D $point, string | int $value): Grid {
        if (!$this->isPointInGrid($point)) {
            throw new \RuntimeException('Tried to update a grid position that doesn\'t exist.');
        }
        $copy = $this->gridByRows;
        $copy[$point->y()][$point->x()] = $value;
        return new Grid($copy);
    }
}
