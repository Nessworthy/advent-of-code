<?php declare(strict_types=1);

namespace Nessworthy\AoC\Common;

use Bramus\Ansi\Writers\WriterInterface;

class OutputWriterAdapter implements WriterInterface
{
    /**
     * @var Output
     */
    private Output $output;

    public function __construct(Output $output)
    {
        $this->output = $output;
    }

    public function write($data)
    {
        $this->output->write((string) $data);
        return $this;
    }

}
