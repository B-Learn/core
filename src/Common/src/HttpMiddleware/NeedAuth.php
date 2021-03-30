<?php
declare(strict_types=1);

namespace App\Common\HttpMiddleware;

use App\Common\Query\QueryBus;
use App\Users\Application\GetUserIdByToken\GetUserIdByTokenQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zholus\SymfonyMiddleware\MiddlewareInterface;

final class NeedAuth implements MiddlewareInterface
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function handle(Request $request): ?Response
    {
        $token = $request->headers->get('Authorization');

        if ($token === null) {
            return new JsonResponse([
                'error' => 'Unauthorized. Access token needed.'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $accessToken = explode(' ', $token)[1] ?? '';

        $userId = $this->queryBus->handle(new GetUserIdByTokenQuery($accessToken));

        if ($userId === null) {
            return new JsonResponse([
                'error' => 'Unauthorized. Invalid access token.'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return null;
    }
}
