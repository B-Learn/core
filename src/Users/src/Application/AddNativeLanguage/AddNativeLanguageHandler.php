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
        $userId = new UserId($command->getUserId());
        $languageId = new LanguageId($command->getLanguageId());

        $language = $this->languages->getById($languageId);

        $user = $this->users->getById($userId);

        $user->addNativeLanguage($language);

        $this->users->add($user);
    }
}
