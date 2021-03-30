<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\BuildingBlock\Entity;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\SharedKernel\Language\Domain\Language;

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
        if (!$this->nativeLanguages->contains($language)) {
            $this->nativeLanguages->add($language);
        }
    }
}
