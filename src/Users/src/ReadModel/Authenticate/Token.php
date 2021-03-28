<?php
declare(strict_types=1);

namespace App\Users\ReadModel\Authenticate;

use DateTimeImmutable;

class Token
{
    public function __construct(
        private string $accessToken,
        private string $refreshToken,
        private DateTimeImmutable $accessTokenExpireAt,
        private DateTimeImmutable $refreshTokenExpireAt
    ) {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getAccessTokenExpireAt(): DateTimeImmutable
    {
        return $this->accessTokenExpireAt;
    }

    public function getRefreshTokenExpireAt(): DateTimeImmutable
    {
        return $this->refreshTokenExpireAt;
    }
}
