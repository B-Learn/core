<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Action;

use App\Common\Command\CommandBus;
use App\Common\Exception\LogicException;
use App\Common\Query\QueryBus;
use App\InternalApi\Common\Validation\Assertion;
use App\Users\Application\Authenticate\AuthenticateCommand;
use App\Users\Application\GetAccessTokenByEmail\GetAccessTokenByEmailQuery;
use App\Users\ReadModel\Authenticate\Token;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class Authenticate extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $errors = Assertion::lazy()
            ->that($email, 'email')->email()->maxLength(191)
            ->that($password, 'password')->minLength(6)->maxLength(32)
            ->getErrors();

        if (!empty($errors)) {
            return new JsonResponse([
                'errors' => $errors
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->commandBus->dispatch(new AuthenticateCommand($email, $password));
        } catch (LogicException $exception) {
            return new JsonResponse([
                'errors' => $exception->toArray()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var Token $token */
        $token = $this->queryBus->handle(new GetAccessTokenByEmailQuery($email));

        return new JsonResponse($this->present($token));
    }

    private function present(Token $token): array
    {
        return [
            'access_token' => $token->getAccessToken(),
            'refresh_token' => $token->getRefreshToken(),
            'access_token_expire_at' => $token->getAccessTokenExpireAt()->format(DateTimeImmutable::ISO8601),
            'refresh_token_expire_at' => $token->getRefreshTokenExpireAt()->format(DateTimeImmutable::ISO8601),
        ];
    }
}
