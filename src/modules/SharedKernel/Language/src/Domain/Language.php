<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Domain;

class Language
{
    public function __construct(
        private readonly LanguageId $id,
        private string $name,
        private string $shortName
    ) {
    }

    public function getId(): LanguageId
    {
        return $this->id;
    }
}
