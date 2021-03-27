<?php
declare(strict_types=1);

namespace App\Users\Application\RegisterUser;

use App\Common\Command\CommandHandler;

final class RegisterUserHandler implements CommandHandler
{
    public function __invoke(RegisterUserCommand $command): void
    {
        dd($command);
    }
}
