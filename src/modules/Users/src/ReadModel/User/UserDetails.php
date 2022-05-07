<?php
declare(strict_types=1);

namespace App\Users\ReadModel\User;

class UserDetails
{
    /**
     * @param string[] $nativeLanguagesIds
     * @param string[] $studyingLanguagesIds
     */
    public function __construct(
        private readonly string $id,
        private readonly string $email,
        private readonly string $username,
        private readonly string $display_name,
        private readonly array $nativeLanguagesIds,
        private readonly array $studyingLanguagesIds
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    public function getNativeLanguagesIds(): array
    {
        return $this->nativeLanguagesIds;
    }

    public function getStudyingLanguagesIds(): array
    {
        return $this->studyingLanguagesIds;
    }
}
