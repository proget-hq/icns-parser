<?php

declare(strict_types=1);

namespace Proget\IcnsParser\Tests;

use PHPUnit\Framework\TestCase;
use Proget\IcnsParser\IcnsParser;

final class IcnsParserTest extends TestCase
{
    public function testParseInvalidFile(): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException('Invalid file'));

        (new IcnsParser())->parse(__FILE__);
    }

    public function testParsing(): void
    {
        $icns = (new IcnsParser())->parse(__DIR__.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'app.icns');
        $elements = $icns->elements();

        self::assertCount(8, $elements);

        self::assertSame('is32', $elements[0]->type());
        self::assertSame('s8mk', $elements[1]->type());
        self::assertSame('il32', $elements[2]->type());
        self::assertSame('l8mk', $elements[3]->type());
        self::assertSame('it32', $elements[4]->type());
        self::assertSame('t8mk', $elements[5]->type());

        self::assertSame('ic08', $elements[6]->type());
        self::assertNotFalse(\imagecreatefromstring($elements[6]->data()));

        self::assertSame('ic09', $elements[7]->type());
        self::assertNotFalse(\imagecreatefromstring($elements[7]->data()));
    }
}
