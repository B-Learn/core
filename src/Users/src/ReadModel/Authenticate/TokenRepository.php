<?php
declare(strict_types=1);

namespace App\Users\ReadModel\Authenticate;

interface TokenRepository
{
    public function getTokenByEmail(string $email): ?Token;
}
