<?php
declare(strict_types=1);

namespace App\Users\Application\AddNativeLanguage;

use App\Common\Command\CommandHandler;
use App\SharedKernel\Language\Domain\LanguageId;
use App\SharedKernel\Language\Domain\LanguageRepository;
use App\Users\Domain\UserId;
use App\Users\Domain\UserRepository;

final class AddNativeLanguageHandler implements CommandHandler
{
    public function __construct(private UserRepository $users, private LanguageRepository $languages)
    {
    }

    public function __invoke(AddNativeLanguageCommand $command): void
    {
        $user = $this->users->getById(new UserId($command->getUserId()));
        $language = $this->languages->getById(new LanguageId($command->getLanguageId()));

        $user->addNativeLanguage($language);

        $this->users->add($user);
    }
}
