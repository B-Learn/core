<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\ReadModel;

interface LanguageRepository
{
    public function getAll(): LanguageCollection;
}
