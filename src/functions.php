<?php declare(strict_types=1);

function between_inclusive($number, $lo, $hi) {
    return $number >= $lo && $number <= $hi;
}
