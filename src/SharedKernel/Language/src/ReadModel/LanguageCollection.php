<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\ReadModel;

class LanguageCollection
{
    private array $languages;

    public function __construct(Language ...$languages)
    {
        $this->languages = $languages;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }
}
