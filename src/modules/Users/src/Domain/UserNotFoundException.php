<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\Exception\Message;

final class UserNotFoundException extends UsersException
{
    public static function byId(UserId $id): self
    {
        return new self(
            [new Message(sprintf('User with id [%s] not found', $id))],
            self::USER_NOT_FOUND
        );
    }

    public static function withCredentials(): self
    {
        return new self(
            [new Message('User with given credentials not found')],
            self::USER_NOT_FOUND
        );
    }
}
