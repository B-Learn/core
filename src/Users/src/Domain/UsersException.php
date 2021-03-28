<?php
declare(strict_types=1);

namespace App\Users\Domain;

use App\Common\Exception\LogicException;

abstract class UsersException extends LogicException
{
    protected const USER_EXISTS_WITH_EMAIL = 1;
    protected const USER_EXISTS_WITH_USERNAME = 2;

    final public function contextBasicCode(): int
    {
        return 100_000;
    }
}
