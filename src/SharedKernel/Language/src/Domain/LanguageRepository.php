<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Domain;

interface LanguageRepository
{
    /**
     * @throws LanguageNotFoundException
     */
    public function getById(LanguageId $id): Language;
}
