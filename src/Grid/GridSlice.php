<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Grid;

use Nessworthy\AoC\Coordinates\Point2D;

class GridSlice extends Grid {

    private Point2D $offset;

    public function __construct(array $grid, Point2D $offset)
    {
        parent::__construct($grid);
        $this->offset = $offset;
    }

    public function getAbsolutePoint(Point2D $point) {
        return new Point2D(
            $point->x() + $this->offset->x(),
            $point->y() + $this->offset->y()
        );
    }
}