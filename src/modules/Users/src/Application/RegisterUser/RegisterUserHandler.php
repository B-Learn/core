<?php
declare(strict_types=1);

namespace App\Users\Application\RegisterUser;

use App\Common\Command\CommandHandler;
use App\Users\Application\PasswordManager;
use App\Users\Domain\User;
use App\Users\Domain\UserExistsException;
use App\Users\Domain\UserRepository;

final class RegisterUserHandler implements CommandHandler
{
    public function __construct(private UserRepository $users, private PasswordManager $passwordManager)
    {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $email = $command->getEmail();
        $username = $command->getUsername();

        if ($this->users->existsWithEmail($email)) {
            throw UserExistsException::withEmail($email);
        }

        if ($this->users->existsWithUserName($username)) {
            throw UserExistsException::withUsername($username);
        }

        $user = User::register(
            $this->users->nextIdentity(),
            $email,
            $username,
            $this->passwordManager->hash($command->getPassword()),
            $command->getDisplayName()
        );

        $this->users->add($user);
    }
}
