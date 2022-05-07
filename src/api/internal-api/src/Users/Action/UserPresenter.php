<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Action;

use App\InternalApi\Languages\Action\LanguagePresenter;
use App\InternalApi\Languages\Resources\Language;
use App\InternalApi\Users\Resources\User;

class UserPresenter
{
    public function __construct(private readonly LanguagePresenter $languagePresenter)
    {
    }

    public function present(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'display_name' => $user->getDisplayName(),
            'native_languages' => array_map(fn (Language $l) => $this->languagePresenter->present($l), $user->getNativeLanguages()),
            'studying_languages' => array_map(fn (Language $l) => $this->languagePresenter->present($l), $user->getStudyingLanguages()),
        ];
    }
}
