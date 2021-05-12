<?php

declare(strict_types=1);

namespace Proget\IcnsParser;

final class Icns
{
    /**
     * @var IcnsElement[]
     */
    private array $elements;

    public function __construct(IcnsElement ...$elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return IcnsElement[]
     */
    public function elements(): array
    {
        return $this->elements;
    }
}
