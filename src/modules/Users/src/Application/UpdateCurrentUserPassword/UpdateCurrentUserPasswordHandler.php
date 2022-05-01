<?php
declare(strict_types=1);

namespace App\Users\Application\UpdateCurrentUserPassword;

use App\Common\Command\CommandHandler;
use App\Users\Application\PasswordManager;
use App\Users\Domain\CurrentPasswordIsNotValidException;
use App\Users\Domain\UserId;
use App\Users\Domain\UserRepository;

final class UpdateCurrentUserPasswordHandler implements CommandHandler
{
    public function __construct(private UserRepository $users, private PasswordManager $passwordManager)
    {
    }

    public function __invoke(UpdateCurrentUserPasswordCommand $command): void
    {
        $user = $this->users->getById(new UserId($command->getUserId()));

        if (!$this->passwordManager->isValid($command->getCurrentPassword(), $user->getPassword())) {
            throw CurrentPasswordIsNotValidException::create();
        }

        $user->changePassword($this->passwordManager->hash($command->getNewPassword()));

        $this->users->add($user);
    }
}
