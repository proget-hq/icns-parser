<?php

declare(strict_types=1);

namespace Proget\IcnsParser;

final class IcnsParser
{
    private const HEADER_MAGIC = 'icns';

    public function parse(string $path): Icns
    {
        $stream = Stream::fromPath($path);
        if ($stream->read(4) !== self::HEADER_MAGIC) {
            throw new \InvalidArgumentException('Invalid file');
        }

        $stream->skip(4); //file length

        $elements = [];
        while ($type = $stream->read(4)) {
            $length = $stream->readUint32() - 8;
            if ($type === 'TOC ') {
                $read = 0;
                while ($read < $length) {
                    $stream->read(4); //type
                    $stream->readUint32() - 8; //size
                    $read += 8;
                }
            } elseif (\in_array($type, ['icnV', 'name', 'info', 'sbtp', 'slct', 'ýÙ/¨'])) {
                $stream->skip($length);
            } else {
                $elements[] = new IcnsElement(
                    $type,
                    $stream->read($length)
                );
            }
        }

        return new Icns(...$elements);
    }
}
