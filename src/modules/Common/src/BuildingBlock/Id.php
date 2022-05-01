<?php
declare(strict_types=1);

namespace App\Common\BuildingBlock;

abstract class Id
{
    public function __construct(private string $uuid)
    {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }
}
