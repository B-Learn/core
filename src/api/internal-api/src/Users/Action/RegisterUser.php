<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Action;

use App\Common\Command\CommandBus;
use App\Common\Exception\LogicException;
use App\InternalApi\Common\Validation\Assertion;
use App\Users\Application\RegisterUser\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class RegisterUser extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->get('email');
        $username = $request->get('username');
        $displayName = $request->get('display_name');
        $password = $request->get('password');

        $errors = Assertion::lazy()
            ->that($email, 'email')->email()->maxLength(191)
            ->that($username, 'username')->minLength(3)->maxLength(32)
            ->that($displayName, 'display_name')->minLength(2)->maxLength(64)
            ->that($password, 'password')->minLength(6)->maxLength(32)
            ->getErrors();

        if (!empty($errors)) {
            return new JsonResponse([
                'errors' => $errors
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->commandBus->dispatch(new RegisterUserCommand(
                $username,
                $displayName,
                $email,
                $password
            ));
        } catch (LogicException $exception) {
            return new JsonResponse([
                'errors' => $exception->toArray()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}
