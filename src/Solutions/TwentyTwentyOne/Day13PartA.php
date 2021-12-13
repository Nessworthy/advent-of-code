<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Generator;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyOne\Visualizer\TransparentPaper;

class Day13PartA implements Solution
{

    private const FOLD_HORIZONTALLY = 'y';
    private const FOLD_VERTICALLY = 'x';
    private TransparentPaper $transparentPaper;

    public function __construct(TransparentPaper $transparentPaper)
    {
        $this->transparentPaper = $transparentPaper;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $grid = [];
        $folds = [];
        foreach ($input->readLine() as $line) {
            if (!$line) {
                continue;
            }

            if (str_starts_with($line, 'fold along ')) {
                [$text, $depth] = explode('=', $line, 2);
                $direction = $text[strlen($text) - 1]; // "x" or "y"

                $folds[] = [$direction, (int) $depth];

                continue;
            }

            [$x, $y] = explode(',', $line, 2);
            if (!isset($grid[$y])) {
                $grid[$y] = [];
            }
            $grid[$y][$x] = true;
        }

        foreach ($grid as $y => $row) {
            ksort($grid[$y]);
        }
        ksort($grid);

        $this->transparentPaper->display($grid);

        foreach($folds as [$direction, $depth]) {
            if ($direction === self::FOLD_HORIZONTALLY) {
                $grid = $this->foldHorizontally($grid, (int) $depth);
                break; // Part 1.
            } elseif ($direction === self::FOLD_VERTICALLY) {
                $grid = $this->foldVertically($grid, (int) $depth);
                break; // Part 1.
            }
            $this->transparentPaper->display($grid);
        }

        return array_sum(array_map('count', $grid));
    }

    private function foldHorizontally(array $grid, int $depth): array
    {
        foreach ($grid as $y => $row) {
            if ($y > $depth) {
                $targetRow = $depth - ($y - $depth);
                $grid[$targetRow] = ($grid[$targetRow] ?? []) + $row;
                ksort($grid[$targetRow]);
                unset($grid[$y]);
            }
        }
        ksort($grid);
        return $grid;
    }

    private function foldVertically(array $grid, int $depth): array
    {
        foreach ($grid as $y => $row) {
            foreach ($row as $x => $unused) {
                if ($x > $depth) {
                    $targetColumn = $depth - ($x - $depth);
                    $grid[$y][$targetColumn] = true;
                    unset($grid[$y][$x]);
                    ksort($grid[$y]);
                }
            }
        }

        return $grid;
    }
}

