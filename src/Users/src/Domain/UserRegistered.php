<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\Event\Event;
use DateTimeImmutable;

final class UserRegistered implements Event
{
    private DateTimeImmutable $occurredAt;

    public function __construct(
        private string $id,
        private string $username,
        private string $email
    ) {
        $this->occurredAt = new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
