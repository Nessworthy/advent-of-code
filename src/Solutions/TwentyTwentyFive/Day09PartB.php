<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Solutions\Context;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\Vector\Line2D;

class Day09PartB implements Solution
{

    private Context $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * The params are intentionally floats
     * so the caller can add a decimal modifier
     * to indicate the area being checked.
     */
    private function rayIntersects(float $x, float $y, Line2D $b): bool
    {
        return $b->from()->x() <= $x
            && min($b->from()->y(), $b->to()->y()) <= $y
            && max($b->from()->y(), $b->to()->y()) >= $y;
    }

    private function isHorizontal(Line2D $line) {
        return $line->to()->x() !== $line->from()->x();
    }

    public function solve(Input $input, Output $output): int|string
    {
        /**
         * Notes
         *
         * So my idea is to double-iterate over each point like in part A, with added checks.
         *
         * One of these needs to check that NO vector passes through the perimeter of rect (a,b)
         *  Note that intersections are permitted.
         *
         * The other one of these needs to determine whether the area is outside or inside the shape.
         *  Take A and create a point 1,1 inside it, then create a vector from that point to x=0 and
         *  check if it intersects any other vectors. If it's an odd number, it's inside. Else, outside.
         *
         */
        $largestArea = 0;

        $points = [];
        $lines = [];
        $horizontalLines = [];
        $verticalLines = [];

        $previous = null;
        $point = null;

        $canvas = new \Imagick();
        $draw = new \ImagickDraw();
        $draw->setFillColor('red');

        $extraLogging = $this->context->isTestRun();
        $doDebugDraw = !$this->context->isTestRun();
        $size = !$this->context->isTestRun() ? 1000 : 100;
        $mod = !$this->context->isTestRun() ? 0.01 : 5;

        // (5639,68743) - (94532,48504)

        foreach ($input->readLine() as $line) {
            $point = new Point2D(...array_map('toInt', explode(',', $line)));
            $points[] = $point;
            if ($previous) {
                $line = new Line2D($previous, $point);
                $lines[] = $line;
                if ($this->isHorizontal($line)) {
                    $horizontalLines[] = $line;
                } else {
                    $verticalLines[] = $line;
                }
                $doDebugDraw && $draw->line($previous->x() * $mod, $previous->y() * $mod, $point->x() * $mod, $point->y() * $mod);
            }

            $previous = $point;
        }

        // Tie it off.
        $line = new Line2D($point, $points[0]);
        $lines[] = $line;
        if ($this->isHorizontal($line)) {
            $horizontalLines[] = $line;
        } else {
            $verticalLines[] = $line;
        }

        $doDebugDraw &&$draw->line($point->x() * $mod, $point->y() * $mod, $points[0]->x() * $mod, $points[0]->y() * $mod);

        $pointCount = count($points);

        $largestA = null;
        $largestB = null;
        $largestC = null;
        $largestD = null;

        foreach ($points as $outerIndex => $a) {
            $output->writeLine('PROGRESS: ' . $outerIndex + 1 . ' / ' . $pointCount);
            for ($innerIndex = $outerIndex + 1; $innerIndex < $pointCount; $innerIndex++) {
                $b = $points[$innerIndex];


                $extraLogging && $output->writeLine(sprintf('Checking the area between %s and %s', $a, $b));

                // Right. If we draw a line from [ e[x], e[y] ] to [ 0, e[y] ], does it pass an odd number of lines?
                $insideXMod = $b->x() <=> $a->x();
                $insideXMod = $insideXMod !== 0 ? $insideXMod / 10 : $insideXMod;
                $insideYMod = $b->y() <=> $a->y();
                $insideYMod = $insideYMod !== 0 ? $insideYMod / 10 : $insideYMod;

                $intersections = 0;

                foreach ($verticalLines as $shapeLine) {
                    if ($this->rayIntersects($a->x() + $insideXMod, $a->y() + $insideYMod, $shapeLine)) {
                       $extraLogging && $output->writeLine(sprintf('  %s intersects (%s)-(%s)', $a, $shapeLine->from(), $shapeLine->to()));
                        $intersections++;
                    } else {
                        $extraLogging && $output->writeLine(sprintf('  %s no intersect (%s)-(%s) (%s,%s)', $a, $shapeLine->from(), $shapeLine->to(), $insideXMod, $insideYMod));
                    }
                }

                if (isEven($intersections)) {
                    $extraLogging && $output->writeLine('  Skip: Area is outside shape.');
                    continue;
                }

                $extraLogging && $output->writeLine('  Area is inside the shape!');

                // Now, determine if the 4 lines that make the shape intersect with any of the lines of the shape.
                $c = new Point2D($b->x(), $a->y());
                $d = new Point2D($a->x(), $b->y());
                foreach ([
                             new Line2D($a, $c), // Horizontal
                             new Line2D($c, $b), // Vertical
                             new Line2D($b, $d), // Horizontal
                             new Line2D($d, $a), // Vertical
                         ] as $li => $line) {

                    $linesToIterate = isEven($li) ? $verticalLines : $horizontalLines;

                    foreach ($linesToIterate as $shapeLine) {
                        if ($a->is($shapeLine->to()) || $a->is($shapeLine->from())) {
                            //$extraLogging && $output->writeLine('    Skipping A ' . $shapeLine->from() . ' - ' . $shapeLine->to());
                            continue;
                        }

                        if ($b->is($shapeLine->to()) || $b->is($shapeLine->from())) {
                            //$extraLogging && $output->writeLine('    Skipping B ' . $shapeLine->from() . ' - ' . $shapeLine->to());
                            continue;
                        }

                        $extraLogging && $output->writeLine('    Evalling ' . $shapeLine->from() . ' - ' . $shapeLine->to());

                        /*if ($a->x() === 7 && $a->y() === 1 && $b->x() === 9 && $b->y() == 7) {
                            $extraLogging && $output->writeLine(sprintf('(%s) - (%s) intersect (%s) - (%s)?  %s', $line->to(), $line->from(), $shapeLine->to(), $shapeLine->from(), $skipOffset));
                        }*/

                        /** @var $line Line2D */
                        if ($line->intersects($shapeLine, true)) {
                            // Saving grace - if one point rests on the line and the other is outside, it is not a problem
                            // OR if the line is on the start or end other axis.
                            if ($li % 2 === 0) {
                                $min = min($a->y(), $b->y());
                                $max = max($a->y(), $b->y());
                                if ($shapeLine->from()->x() === $a->x() || $shapeLine->from()->x() === $b->x()) {
                                    $extraLogging && $output->writeLine(sprintf('  Area intersected by (%s)-(%s) BUT it\'s ok - on the border.', $shapeLine->from(), $shapeLine->to()));
                                    continue;
                                }
                                if ((($shapeLine->from()->y() === $min && $shapeLine->to()->y() < $min) || ($shapeLine->from()->y() === $max && $shapeLine->to()->y() > $max))
                                    || (($shapeLine->to()->y() === $min && $shapeLine->from()->y() < $min) || ($shapeLine->to()->y() === $max && $shapeLine->from()->y() > $max))) {
                                    $extraLogging && $output->writeLine(sprintf('  Area intersected by (%s)-(%s) BUT it\'s ok.', $shapeLine->from(), $shapeLine->to()));
                                    continue;
                                }
                            } else {
                                $min = min($a->x(), $b->x());
                                $max = max($a->x(), $b->x());
                                if ($shapeLine->from()->y() === $a->y() || $shapeLine->from()->y() === $b->y()) {
                                    $extraLogging && $output->writeLine(sprintf('  Area intersected by (%s)-(%s) BUT it\'s ok - on the border.', $shapeLine->from(), $shapeLine->to()));
                                    continue;
                                }
                                if ((($shapeLine->from()->x() === $min && $shapeLine->to()->x() < $min) || ($shapeLine->from()->x() === $max && $shapeLine->to()->x() > $max))
                                    || (($shapeLine->to()->x() === $min && $shapeLine->from()->x() < $min) || ($shapeLine->to()->x() === $max && $shapeLine->from()->x() > $max))) {
                                    $extraLogging && $output->writeLine(sprintf('  Area intersected by (%s)-(%s) BUT it\'s ok.', $shapeLine->from(), $shapeLine->to()));
                                    continue;
                                }
                            }

                            $extraLogging && $output->writeLine(sprintf('  Skip: Area intersected by (%s)-(%s)', $shapeLine->from(), $shapeLine->to()));
                            break 3;
                        }
                    }
                }

                $extraLogging && $output->writeLine('  Area not intersected!');

                $area = $a->getAreaBetween($b);
                $largestArea = max($largestArea, $area);

                if ($largestArea === $area) {
                    $largestA = $a;
                    $largestB = $b;
                    $largestC = $c;
                    $largestD = $d;
                }
                $extraLogging && $output->writeLine('  Largest area is ' . $largestArea . ' (' . $area . ')');
            }
        }

        if ($largestA) {
            $doDebugDraw &&$draw->setFillColor('blue');
            $doDebugDraw &&$draw->setFillOpacity(0.5);
            $doDebugDraw &&$draw->line($largestA->x() * $mod, $largestA->y() * $mod, $largestC->x() * $mod, $largestC->y() * $mod);
            $doDebugDraw &&$draw->line($largestD->x() * $mod, $largestD->y() * $mod, $largestA->x() * $mod, $largestA->y() * $mod);
            $doDebugDraw &&$draw->setFillColor('green');
            $doDebugDraw &&$draw->line($largestC->x() * $mod, $largestC->y() * $mod, $largestB->x() * $mod, $largestB->y() * $mod);
            $doDebugDraw &&$draw->line($largestB->x() * $mod, $largestB->y() * $mod, $largestD->x() * $mod, $largestD->y() * $mod);
        }

        $doDebugDraw &&$canvas->newImage($size, $size, 'white');
        $doDebugDraw &&$canvas->drawImage($draw);
        $doDebugDraw &&$canvas->setImageFormat('png');
        $doDebugDraw &&$canvas->writeImage('debug.png');

        $output->writeLine(sprintf('Largest area was from area (%s) - (%s)', $largestA, $largestB));

        return $largestArea;
    }
}
