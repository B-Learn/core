<?php
declare(strict_types=1);

namespace App\InternalApi\Common\Auth;

use App\Common\Query\QueryBus;
use App\Users\Application\GetUserIdByToken\GetUserIdByTokenQuery;
use Symfony\Component\HttpFoundation\RequestStack;

final class TokenAuthenticatedUserContext implements AuthenticatedUserContext
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly QueryBus $queryBus
    ) {
    }

    public function getUserId(): string
    {
        $request = $this->requestStack->getMainRequest();

        $token = $request->headers->get('Authorization', '');

        $accessToken = explode(' ', $token)[1] ?? '';

        return $this->queryBus->handle(new GetUserIdByTokenQuery($accessToken));
    }
}
