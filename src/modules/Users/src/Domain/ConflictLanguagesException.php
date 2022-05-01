<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\Exception\Message;
use App\SharedKernel\Language\Domain\LanguageId;

final class ConflictLanguagesException extends UsersException
{
    public static function withNative(LanguageId $id): self
    {
        return new self(
            [new Message(
                sprintf('There is conflict with a language with id [%s], the language already marked as native', $id)
            )],
            self::CONFLICT_NATIVE_LANGUAGE
        );
    }

    public static function withStudying(LanguageId $id): self
    {
        return new self(
            [new Message(
                sprintf('There is conflict with a language with id [%s], the language already marked as studying', $id)
            )],
            self::CONFLICT_STUDYING_LANGUAGE
        );
    }
}
