<?php
declare(strict_types=1);

namespace App\Users\Application\Authenticate;

use App\Common\Command\CommandHandler;
use App\Users\Application\PasswordManager;
use App\Users\Domain\AuthService;
use App\Users\Domain\UserNotFoundException;
use App\Users\Domain\UserRepository;

final class AuthenticateHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $users,
        private PasswordManager $passwordManager,
        private AuthService $authService
    ) {
    }

    public function __invoke(AuthenticateCommand $command): void
    {
        $user = $this->users->getByEmail($command->getEmail());

        if (!$this->passwordManager->isValid($command->getPassword(), $user->getPassword())) {
            throw UserNotFoundException::withCredentials();
        }

        $this->authService->auth($user);
    }
}
