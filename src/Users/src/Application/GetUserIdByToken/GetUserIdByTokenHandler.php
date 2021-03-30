<?php
declare(strict_types=1);

namespace App\Users\Application\GetUserIdByToken;

use App\Common\Query\QueryHandler;
use App\Users\ReadModel\Authenticate\TokenRepository;

final class GetUserIdByTokenHandler implements QueryHandler
{
    public function __construct(private TokenRepository $tokenRepository)
    {
    }

    public function __invoke(GetUserIdByTokenQuery $query): ?string
    {
        return $this->tokenRepository->getUserIdByToken($query->getAccessToken());
    }
}
