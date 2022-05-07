<?php
declare(strict_types=1);

namespace App\InternalApi\Languages\Resources;

use App\SharedKernel\Language\ReadModel\Language as LanguageReadModel;

class LanguageFactory
{
    public function fromReadModel(LanguageReadModel $language): Language
    {
        return new Language(
            $language->getId(),
            $language->getName(),
            $language->getShortName(),
        );
    }
}
