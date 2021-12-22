<?php declare(strict_types=1);

function between_inclusive($number, $lo, $hi) {
    return $number >= $lo && $number <= $hi;
}

function curry(callable $callback, ...$initialArgs): callable {
    return static function (...$args) use ($callback, $initialArgs) {
        return call_user_func_array($callback, array_merge($initialArgs, $args));
    };
}

function rcurry(callable $callback, ...$finalArgs): callable {
    return static function (...$args) use ($callback, $finalArgs) {
        return call_user_func_array($callback, array_merge($args, $finalArgs));
    };
}

function toInt($var): int {
    return (int) $var;
}

function generator_reduce(Generator $generator, callable $callback, $initial = null) {
    $return = $initial;
    foreach ($generator as $item) {
        $return = $callback($return, $item);
    }
    return $return;
}
