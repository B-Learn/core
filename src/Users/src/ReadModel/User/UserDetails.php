<?php
declare(strict_types=1);

namespace App\Users\ReadModel\User;

class UserDetails
{
    public function __construct(
        private string $id,
        private string $username,
        private string $display_name,
        private array $nativeLanguagesIds,
        private array $studyingLanguagesIds
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

    public function getNativeLanguagesIds(): array
    {
        return $this->nativeLanguagesIds;
    }

    public function getStudyingLanguagesIds(): array
    {
        return $this->studyingLanguagesIds;
    }
}
