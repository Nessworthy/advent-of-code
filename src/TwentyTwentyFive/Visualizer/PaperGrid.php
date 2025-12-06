<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyFive\Visualizer;

use Bramus\Ansi\Ansi;
use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Grid\Grid;

class PaperGrid
{
    private Ansi $ansi;

    public function __construct(Ansi $ansi)
    {
        $this->ansi = $ansi;
    }

    public function display(Grid $grid, array $changeStack, Point2D $currentPoint): void
    {
        foreach ($grid->getRows() as $y => $row) {
            $this->ansi->lf();
            foreach ($row as $x => $value) {
                $point = new Point2D($x, $y);
                if (isset($changeStack[$point->__toString()])) {
                    $this->ansi->color([\Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR::COLOR_BG_BLUE]);
                }
                if ($point->is($currentPoint)) {
                    $this->ansi->color([\Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR::COLOR_BG_RED]);
                }
                if ($value === '@') {
                    $this->ansi->color([\Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR::COLOR_FG_YELLOW]);
                    $this->ansi->text($value);
                } else {
                    $this->ansi->text($value);
                }
                $this->ansi->reset();
            }
        }
        $this->ansi->lf();
    }
}
