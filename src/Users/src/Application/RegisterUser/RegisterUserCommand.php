<?php
declare(strict_types=1);

namespace App\Users\Application\RegisterUser;

use App\Common\Command\Command;

final class RegisterUserCommand implements Command
{
    public function __construct(
        private string $username,
        private string $displayName,
        private string $email,
        private string $password
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
