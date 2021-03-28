<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\Exception\Message;

final class UserExistsException extends UsersException
{
    public static function withEmail(string $email): self
    {
        return new self(
            [new Message(sprintf('User with email [%s] already exists', $email))],
            self::USER_EXISTS_WITH_EMAIL
        );
    }

    public static function withUsername(string $username): self
    {
        return new self(
            [new Message(sprintf('User with username [%s] already exists', $username))],
            self::USER_EXISTS_WITH_USERNAME
        );
    }
}
