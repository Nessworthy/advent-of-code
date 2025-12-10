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

    public function from(): Point2D {
        return $this->from;
    }

    public function to(): Point2D {
        return $this->to;
    }

    /**
     * Code shamelessly used from GeeksForGeeks - full credit goes here
     * on how to determine whether points intersect and are/are not collinear.
     * @link https://www.geeksforgeeks.org/dsa/check-if-two-given-line-segments-intersect/
     */

    /**
     * Check if q lies on the line p,r
     */
    private function onSegment(Point2D $p, Point2D $q, Point2D $r): bool {
        return $q->x() <= max($p->x(), $r->x())
                && $q->x() >= min($p->x(), $r->x())
                && $q->y() <= max($p->y(), $r->y())
                && $q->y() >= min($p->y(), $r->y());

    }


    private const COLLINEAR = 0;
    private const CLOCKWISE = 1;
    private const COUNTERCLOCKWISE = 2;

    private function getOrientation(Point2D $p, Point2D $q, Point2D $r): int {
        $value = ($q->y() - $p->y()) * ($r->x() - $q->x())
            - ($q->x() - $p->x()) * ($r->y() - $q->y());

        if ($value === 0) {
            return self::COLLINEAR;
        }

        return $value > 0 ? self::CLOCKWISE : self::COUNTERCLOCKWISE;
    }

    public function intersects(Line2D $line, $includeResting = true): bool {

        // Find orientations
        $o1 = $this->getOrientation($this->from(), $this->to(), $line->from());
        $o2 = $this->getOrientation($this->from(), $this->to(), $line->to());
        $o3 = $this->getOrientation($line->from(), $line->to(), $this->from());
        $o4 = $this->getOrientation($line->from(), $line->to(), $this->to());

        // If one line plus an anchor point from the other line both have different orientations
        // for both lines, then they do intersect.
        if ($o1 !== $o2 && $o3 !== $o4) {
            if ($includeResting) {
                return true;
            }

            // Check if any points are collinear.
            return ! in_array(self::COLLINEAR, [$o1, $o2, $o3, $o4], true);
        }

        if (!$includeResting) {
            return false;
        }

        // Check if both are true.
        // One line and one point from the other line are collinear.
        // The given point also lies on the given line.

        if ($o1 === self::COLLINEAR && $this->onSegment($this->from(), $line->from(), $this->to())) {
            return true;
        }

        if ($o2 === self::COLLINEAR && $this->onSegment($this->from(), $line->to(), $this->to())) {
            return true;
        }

        if ($o3 === self::COLLINEAR && $this->onSegment($line->from(), $this->from(), $line->to())) {
            return true;
        }

        if ($o4 === self::COLLINEAR && $this->onSegment($line->from(), $this->to(), $line->to())) {
            return true;
        }

        return false;
    }
}
