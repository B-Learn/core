<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Domain;

class Language
{
    private LanguageId $id;
    private string $name;
    private string $shortName;

    public function __construct(LanguageId $id, string $name, string $shortName)
    {
        $this->id = $id;
        $this->name = $name;
        $this->shortName = $shortName;
    }

    public function getId(): LanguageId
    {
        return $this->id;
    }
}
