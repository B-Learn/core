<?php
declare(strict_types=1);

namespace App\InternalApi\Languages\Resources;

class Language
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $shortName,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }
}
