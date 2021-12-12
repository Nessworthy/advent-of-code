<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\Visualizer;

use Bramus\Ansi\Ansi;
use Bramus\Ansi\Traits\EscapeSequences\SGR;

class JellyfishFlashers
{
    private Ansi $ansi;

    public function __construct(Ansi $ansi)
    {
        $this->ansi = $ansi;
    }

    public function display(array $grid): void
    {
        foreach ($grid as $y => $row) {
            $this->ansi->lf();
            foreach ($row as $x => $value) {
                if ($value > 9) {
                    $this->ansi->color([\Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR::COLOR_BG_YELLOW_BRIGHT]);
                    $this->ansi->text('0');
                    $this->ansi->reset();
                } else {
                    $this->ansi->text($value);
                }
            }
        }
        $this->ansi->lf();
    }
}
