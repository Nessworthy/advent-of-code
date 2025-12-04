<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyFour\Vector;

use Nessworthy\AoC\Coordinates\Point2D;

class Line2D {
    private Point2D $from;
    private Point2D $to;

    private int $incrX;
    private int $incrY;

    public function __construct(Point2D $from, Point2D $to)
    {
        $this->from = $from;
        $this->to = $to;

        $this->incrX = $to->x() - $from->x();
        $this->incrY = $to->y() - $from->y();
    }

    public function next(int $n = 1): Point2D {
        return new Point2D($this->to->x() + ($this->incrX * $n), $this->to->y() + ($this->incrY * $n));
    }

    public function prev(int $n = 1): Point2D {
        return new Point2D($this->from->x() - ($this->incrX * $n), $this->from->y() - ($this->incrY * $n));
    }
}
