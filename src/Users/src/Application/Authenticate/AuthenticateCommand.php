<?php
declare(strict_types=1);

namespace App\Users\Application\Authenticate;

use App\Common\Command\Command;

final class AuthenticateCommand implements Command
{
    public function __construct(
        private string $email,
        private string $password
    ) {
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
