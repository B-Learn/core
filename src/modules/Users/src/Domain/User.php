<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\BuildingBlock\Entity;
use App\SharedKernel\Language\Domain\Language;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User extends Entity
{
    public function __construct(
        private UserId $id,
        private string $email,
        private string $username,
        private string $password,
        private string $displayName,
        private Collection $nativeLanguages,
        private Collection $studyingLanguages,
        private DateTimeImmutable $createdAt
    ) {
    }

    public static function register(
        UserId $id,
        string $email,
        string $username,
        string $password,
        string $displayName
    ): self {
        $user = new self(
            $id,
            $email,
            $username,
            $password,
            $displayName,
            new ArrayCollection(),
            new ArrayCollection(),
            new DateTimeImmutable()
        );

        $user->publishEvent(new UserRegistered($id->getUuid(), $username, $email));

        return $user;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function addNativeLanguage(Language $language): void
    {
        if ($this->studyingLanguages->contains($language)) {
            throw ConflictLanguagesException::withStudying($language->getId());
        }

        if (!$this->nativeLanguages->contains($language)) {
            $this->nativeLanguages->add($language);
        }
    }

    public function removeNativeLanguage(Language $language): void
    {
        if ($this->nativeLanguages->contains($language)) {
            $this->nativeLanguages->removeElement($language);
        }
    }

    public function addStudyingLanguage(Language $language): void
    {
        if ($this->nativeLanguages->contains($language)) {
            throw ConflictLanguagesException::withNative($language->getId());
        }

        if (!$this->studyingLanguages->contains($language)) {
            $this->studyingLanguages->add($language);
        }
    }

    public function removeStudyingLanguage(Language $language): void
    {
        if ($this->studyingLanguages->contains($language)) {
            $this->studyingLanguages->removeElement($language);
        }
    }

    public function changePassword(string $newHashedPassword): void
    {
        $this->password = $newHashedPassword;
    }

    public function changeDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    public function changeUserName(string $username): void
    {
        $this->username = $username;
    }
}
