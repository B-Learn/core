<?php
declare(strict_types=1);

namespace App\Users\Application\UpdateCurrentUserDetails;

use App\Common\Command\Command;

final class UpdateCurrentUserDetailsCommand implements Command
{
    public function __construct(
        private string $userId,
        private ?string $username,
        private ?string $displayName
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }
}
