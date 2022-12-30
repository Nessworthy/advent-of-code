<?php declare(strict_types=1);

use Auryn\Injector;
use Nessworthy\AoC\Common\Output;

require_once __DIR__ . '/../vendor/autoload.php';

$year = (int) ($argv[1] ?? null);
$question = (int) ($argv[2] ?? null);
$part = $argv[3] ?? null;

if (!$year || !$question || !$part) {
    exit(1);
}

if (!isset(YEAR_MAP[$year])) {
    exit(2);
}

if ($question < 1 || $question > 31) {
    exit(3);
}

if (!in_array($part, ['a', 'b'], true)) {
    exit(4);
}

function check_and_create_dir(string $path) {
    if (!is_dir($path) && !mkdir($concurrentDirectory = $path) && !is_dir($concurrentDirectory)) {
        throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
    }
}

function check_and_create_file(string $filePath) {
    if (!file_exists($filePath)) {
        touch($filePath);
    }
}

$paddedDay = str_pad((string) $question, 2, '0', STR_PAD_LEFT);

$injector = new Injector();

$injector->share($injector); // #yolo

$injector->share(Output::class);

$output = $injector->make(Output::class);

$output->writeLine('Checking input year..');
check_and_create_dir(__DIR__ . '/../input/' . $year);

$output->writeLine('Checking input file..');
check_and_create_file(__DIR__ . '/../input/' . $year . '/' . $paddedDay . $part . '.txt');

$output->writeLine('Checking solutions year..');
check_and_create_dir(__DIR__ . '/../src/Solutions/' . YEAR_MAP[$year]);

$output->writeLine('Checking solutions file..');
check_and_create_file(sprintf('%s/../src/Solutions/%s/Day%sPart%s.php', __DIR__, YEAR_MAP[$year], $paddedDay, strtoupper($part)));

$output->writeLine('Checking test input year..');
check_and_create_dir(__DIR__ . '/../test/input/' . $year);

$output->writeLine('Checking test input file..');
check_and_create_file(sprintf('%s/../test/input/%s/%s.txt', __DIR__, $year, $paddedDay));

$output->writeLine('Checking test output year..');
check_and_create_dir(sprintf('%s/../test/output/%s', __DIR__, $year));

$output->writeLine('Checking test output file..');
check_and_create_file(sprintf('%s/../test/output/%s/%s%s.txt', __DIR__, $year, $paddedDay, $part));


$output->writeLine('Done!');
exit(0);
