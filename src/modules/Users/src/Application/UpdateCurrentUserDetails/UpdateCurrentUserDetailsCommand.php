<?php
declare(strict_types=1);

namespace App\Users\Application\UpdateCurrentUserDetails;

use App\Common\Command\Command;

final class UpdateCurrentUserDetailsCommand implements Command
{
    public function __construct(
        private readonly string $userId,
        private readonly ?string $userName,
        private readonly ?string $displayName
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }
}
