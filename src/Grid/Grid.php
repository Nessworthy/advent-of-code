<?php declare(strict_types=1);

namespace Nessworthy\AoC\Grid;

use Nessworthy\AoC\Coordinates\Point2D;

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
}
