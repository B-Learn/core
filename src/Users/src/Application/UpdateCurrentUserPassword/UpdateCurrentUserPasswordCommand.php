<?php
declare(strict_types=1);

namespace App\Users\Application\UpdateCurrentUserPassword;

use App\Common\Command\Command;

final class UpdateCurrentUserPasswordCommand implements Command
{
    public function __construct(private string $userId, private string $currentPassword, private string $newPassword)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}
