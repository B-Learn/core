<?php
declare(strict_types=1);

namespace App\Users\Application\GetUserIdByToken;

use App\Common\Query\Query;

final class GetUserIdByTokenQuery implements Query
{
    public function __construct(private string $accessToken)
    {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
