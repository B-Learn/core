<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\Exception\Message;

final class CurrentPasswordIsNotValidException extends UsersException
{
    public static function create(): self
    {
        return new self(
            [new Message('Current password is not valid')],
            self::CURRENT_PASSWORD_IS_NOT_VALID
        );
    }
}
