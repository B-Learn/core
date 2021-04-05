<?php
declare(strict_types=1);

namespace App\Users\ReadModel\User;

use App\SharedKernel\Language\ReadModel\LanguageCollection;

class UserDetails
{
    public function __construct(
        private string $id,
        private string $username,
        private string $display_name,
        private LanguageCollection $nativeLanguages,
        private LanguageCollection $studyingLanguages
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    public function getNativeLanguages(): LanguageCollection
    {
        return $this->nativeLanguages;
    }

    public function getStudyingLanguages(): LanguageCollection
    {
        return $this->studyingLanguages;
    }
}
