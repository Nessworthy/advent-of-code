<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\DirectoryTree\DirectoryTree;
use Nessworthy\AoC\TwentyTwentyTwo\DirectoryTree\TreeObject;

class Day07PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $tree = new DirectoryTree();

        $lines = $input->readLine();

        while ($line = $lines->current()) {
            if ($line[0] === '$') {
                $args = explode(' ', $line);
                switch ($args[1]) {
                    case 'cd':
                        if ($args[2] === '/') {
                            $output->writeLine('Changing dir to root');
                            $tree->changeDirectoryToRoot();
                            break;
                        }
                        if ($args[2] === '..') {
                            $output->writeLine('Going up a level');
                            $tree->traverseUpDirectory();
                            break;
                        }
                        $output->writeLine('Changing dir to ' . $args[2]);
                        $tree->changeDirectory($args[2]);
                        break;
                    case 'ls':
                        $output->writeLine('Listing dir contents');
                        $lines->next();
                        while ($objectLine = $lines->current()) {
                            if ($objectLine[0] === '$') {
                                $output->writeLine('  Output ended.');
                                continue 3;
                            }

                            [$size, $objName] = explode(' ', $objectLine);

                            if ($size === 'dir') {
                                $output->writeLine('  Saw directory called ' . $objName);
                                $tree->createDirectory($objName);
                            } else {
                                $output->writeLine('  Saw file called ' . $objName);
                                $tree->createFile($objName, (int) $size);
                            }

                            $lines->next();
                        }
                        break;
                    default:
                        $output->writeLine('Unknown command: ' . $line);
                        break;
                }
            }
            $lines->next();
        }

        return generator_reduce(
            $tree->listAllDirectories(),
            static function (int $size, TreeObject $object) use ($tree) {
                $objectSize = $tree->getObjectSize($object->getId());
                if ($objectSize > 100000) {
                    return $size;
                }
                return $size + $objectSize;
            }, 0
        );
    }

}
