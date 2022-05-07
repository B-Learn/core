<?php
declare(strict_types=1);

namespace App\Users\Application\GetUserDetails;

use App\Common\Query\Query;

final class GetUserDetailsQuery implements Query
{
    public function __construct(private readonly string $userId)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
