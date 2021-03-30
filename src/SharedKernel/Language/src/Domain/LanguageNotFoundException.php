<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Domain;

use App\Common\Exception\Message;

final class LanguageNotFoundException extends LanguageException
{
    public static function byId(LanguageId $id): self
    {
        return new self(
            [new Message(sprintf('Language with id [%s] not found', $id))],
            self::LANGUAGE_NOT_FOUND
        );
    }
}
