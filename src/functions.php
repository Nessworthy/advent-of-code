<?php declare(strict_types=1);

function between_inclusive($number, $lo, $hi) {
    return $number >= $lo && $number <= $hi;
}

function curry(callable $callback, ...$initialArgs): callable {
    return static function (...$args) use ($callback, $initialArgs) {
        return call_user_func_array($callback, array_merge($initialArgs, $args));
    };
}
