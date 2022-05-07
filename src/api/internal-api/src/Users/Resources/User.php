<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Resources;

use App\InternalApi\Languages\Resources\Language;

class User
{
    /**
     * @param Language[] $nativeLanguages
     * @param Language[] $studyingLanguages
     */
    public function __construct(
        private readonly string $id,
        private readonly string $username,
        private readonly string $displayName,
        private readonly ?string $email,
        private readonly array $nativeLanguages,
        private readonly array $studyingLanguages,
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
        return $this->displayName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getNativeLanguages(): array
    {
        return $this->nativeLanguages;
    }

    public function getStudyingLanguages(): array
    {
        return $this->studyingLanguages;
    }
}
