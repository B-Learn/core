<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\UI\Http\Api\Presenters;

use App\SharedKernel\Language\ReadModel\Language;

class LanguagePresenter
{
    public function present(Language $language): array
    {
        return [
            'id' => $language->getId(),
            'name' => $language->getName(),
            'short_name' => $language->getShortName()
        ];
    }
}

