<?php declare(strict_types=1);

use Auryn\Injector;
use Nessworthy\AoC\Common\Input;
require_once __DIR__ . '/../vendor/autoload.php';

$solve = $argv[1] ?? null;

// Auryn - Bootstrap

$injector = new Injector();

$injector->share($injector); // #yolo

$matches = [];
preg_match('#^(?<year>\d+)-(?<day>\d+)(?<part>\w+)$#', $solve, $matches);

$inputPath = __DIR__ . '/../input/' . $matches['year'] . '/' . $matches['day'] . 'a.txt';

if (!file_exists($inputPath)) {
    echo 'Unable to run - day input file not found.';
    exit(0);
}

$injector->define(Input::class, [
    ':filePath' => __DIR__ . '/../input/' . $matches['year'] . '/' . $matches['day'] . 'a.txt'
]);

$className = sprintf('Day%sPart%s', $matches['day'], strtoupper($matches['part']));

$solution = $injector->make(sprintf('Nessworthy\AoC\Solutions\%s\%s', YEAR_MAP[$matches['year']], $className));
$result = $injector->execute([$solution, 'solve']);
echo 'Answer given: ' . "\n" . '(' . gettype($result) . ') ' . $result;

