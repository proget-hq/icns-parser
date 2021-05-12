<?php

declare(strict_types=1);

namespace Proget\IcnsParser;

final class Stream
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @param resource $stream
     */
    private function __construct($stream)
    {
        if (!\is_resource($stream)) {
            throw new \InvalidArgumentException('Not a resource');
        }

        $this->stream = $stream;
    }

    public static function fromPath(string $path): self
    {
        $stream = @\fopen($path, 'rb');
        if ($stream === false) {
            throw new \InvalidArgumentException('Invalid path');
        }

        return new self($stream);
    }

    public function skip(int $length): void
    {
        $this->read($length);
    }

    public function readUint32(): int
    {
        $value = \unpack('N', $this->read(4));
        if ($value === false) {
            throw new \RuntimeException('Read u32 failed');
        }

        return $value[1];
    }

    public function read(int $length): string
    {
        $data = \fread($this->stream, $length);
        if ($data === false) {
            throw new \RuntimeException('Read failed');
        }

        return $data;
    }
}
