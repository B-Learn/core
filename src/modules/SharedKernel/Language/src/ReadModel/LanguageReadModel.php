<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\ReadModel;

interface LanguageReadModel
{
    public function getAll(): LanguageCollection;
    public function getAllByIds(string ...$ids): LanguageCollection;
}
