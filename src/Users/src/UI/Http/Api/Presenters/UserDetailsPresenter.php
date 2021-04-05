<?php
declare(strict_types=1);

namespace App\Users\UI\Http\Api\Presenters;

use App\Users\ReadModel\User\UserDetails;

class UserDetailsPresenter
{
    public function present(UserDetails $userDetails): array
    {
        return [
            'id' => $userDetails->getId(),
            'username' => $userDetails->getUsername(),
            'display_name' => $userDetails->getDisplayName(),
            'native_languages' => $userDetails->getNativeLanguagesIds(),
            'studying_languages' => $userDetails->getStudyingLanguagesIds(),
        ];
    }
}
