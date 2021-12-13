<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\Visualizer;

use Bramus\Ansi\Ansi;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;

class TransparentPaper
{
    private Ansi $ansi;

    private const BLANK = '.';
    private const HOLE = '#';

    public function __construct(Ansi $ansi)
    {
        $this->ansi = $ansi;
    }

    public function display(array $grid): void
    {
        $highestX = 0;
        $highestY = 0;

        foreach ($grid as $y => $row) {
            $highestY = max($y, $highestY);
            foreach ($row as $x => $unused) {
                $highestX = max($x, $highestX);
            }
        }

        $lastY = -1;

        foreach ($grid as $y => $row) {
            $this->ansi->lf();

            while ($lastY < $y - 1) {
                ++$lastY;
                $this->ansi->text(str_repeat(self::BLANK, $highestX + 1));
                $this->ansi->lf();
            }

            $line = '';

            foreach ($row as $x => $value) {
                $line = str_pad($line, $x, self::BLANK, STR_PAD_RIGHT);
                $line .= self::HOLE;
            }

            $line = str_pad($line, $highestX + 1, self::BLANK, STR_PAD_RIGHT);

            $this->ansi->text($line);

            $lastY = $y;
        }

        $this->ansi->lf();
    }
}
