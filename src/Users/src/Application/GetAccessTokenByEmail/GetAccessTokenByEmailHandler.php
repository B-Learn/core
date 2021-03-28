<?php
declare(strict_types=1);

namespace App\Users\Application\GetAccessTokenByEmail;

use App\Common\Query\QueryHandler;
use App\Users\ReadModel\Authenticate\Token;
use App\Users\ReadModel\Authenticate\TokenRepository;
use DateTimeImmutable;

final class GetAccessTokenByEmailHandler implements QueryHandler
{
    private TokenRepository $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function __invoke(GetAccessTokenByEmailQuery $query): ?Token
    {
        $token = $this->tokenRepository->getTokenByEmail($query->getEmail());

        if ($token === null) {
            return null;
        }

        if ($token->getAccessTokenExpireAt() < new DateTimeImmutable()) {
            return null;
        }

        return $token;
    }
}
