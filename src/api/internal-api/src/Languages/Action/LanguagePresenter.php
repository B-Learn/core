<?php
declare(strict_types=1);

namespace App\InternalApi\Languages\Action;


use App\InternalApi\Languages\Resources\Language;

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

