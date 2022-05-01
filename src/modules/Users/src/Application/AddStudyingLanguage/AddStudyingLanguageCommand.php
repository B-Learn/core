<?php
declare(strict_types=1);

namespace App\Users\Application\AddStudyingLanguage;

use App\Common\Command\Command;

final class AddStudyingLanguageCommand implements Command
{
    public function __construct(private string $userId, private string $languageId)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getLanguageId(): string
    {
        return $this->languageId;
    }
}
