<?php
declare(strict_types=1);

namespace App\Users\UI\Http\Api\Presenters;

use App\SharedKernel\Language\ReadModel\Language;
use App\SharedKernel\Language\UI\Http\Api\Presenters\LanguagePresenter;
use App\Users\ReadModel\User\UserDetails;

class UserDetailsPresenter
{
    public function __construct(private LanguagePresenter $languagePresenter)
    {
    }

    public function present(UserDetails $userDetails): array
    {
        return [
            'id' => $userDetails->getId(),
            'username' => $userDetails->getUsername(),
            'display_name' => $userDetails->getDisplayName(),
            'native_languages' => array_map(function (Language $language) {
                return $this->languagePresenter->present($language);
            }, $userDetails->getNativeLanguages()->getLanguages()),
            'studying_languages' => array_map(function (Language $language) {
                return $this->languagePresenter->present($language);
            }, $userDetails->getStudyingLanguages()->getLanguages()),
        ];
    }
}
