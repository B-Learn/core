<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\BuildingBlock\Entity;
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
}
