<?php
declare(strict_types=1);

namespace App\Users\Application\UpdateCurrentUserDetails;

use App\Common\Command\CommandHandler;
use App\Users\Domain\UserExistsException;
use App\Users\Domain\UserId;
use App\Users\Domain\UserRepository;

final class UpdateCurrentUserDetailsHandler implements CommandHandler
{
    public function __construct(private UserRepository $users)
    {
    }

    public function __invoke(UpdateCurrentUserDetailsCommand $command): void
    {
        $user = $this->users->getById(new UserId($command->getUserId()));

        if ($command->getDisplayName() !== null) {
            $user->changeDisplayName($command->getDisplayName());
        }

        $newUsername = $command->getUserName();

        if ($newUsername !== null) {
            if ($this->users->existsWithUserName($newUsername)) {
                throw UserExistsException::withUsername($newUsername);
            }

            $user->changeUserName($newUsername);
        }

        $this->users->add($user);
    }
}
