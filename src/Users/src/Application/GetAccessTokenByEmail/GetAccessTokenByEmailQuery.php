<?php
declare(strict_types=1);

namespace App\Users\Application\GetAccessTokenByEmail;

use App\Common\Query\Query;

final class GetAccessTokenByEmailQuery implements Query
{
    public function __construct(private string $email)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
