<?php

declare(strict_types=1);

namespace Proget\IcnsParser\Tests;

use PHPUnit\Framework\TestCase;
use Proget\IcnsParser\Stream;

final class StreamTest extends TestCase
{
    public function testExceptionWithInvalidFile(): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException('Invalid path'));

        Stream::fromPath('nope');
    }

    public function testStream(): void
    {
        $stream = Stream::fromPath(__FILE__);

        self::assertSame('<?', $stream->read(2));
        $stream->skip(1);
        self::assertSame('hp', $stream->read(2));
    }
}
