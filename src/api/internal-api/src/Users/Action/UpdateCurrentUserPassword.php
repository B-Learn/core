<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Action;

use App\Common\Command\CommandBus;
use App\Common\Exception\LogicException;
use App\InternalApi\Common\Auth\AuthenticatedUserContext;
use App\InternalApi\Common\Validation\Assertion;
use App\Users\Application\UpdateCurrentUserPassword\UpdateCurrentUserPasswordCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UpdateCurrentUserPassword extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly AuthenticatedUserContext $loggedUserContext
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $currentPassword = $request->get('current_password');
        $newPassword = $request->get('new_password');

        $errors = Assertion::lazy()
            ->that($currentPassword, 'current_password')->minLength(6)->maxLength(32)
            ->that($newPassword, 'new_password')->minLength(6)->maxLength(32)->notSame($currentPassword, $newPassword)
            ->getErrors();

        if (!empty($errors)) {
            return new JsonResponse([
                'errors' => $errors
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->commandBus->dispatch(new UpdateCurrentUserPasswordCommand(
                $this->loggedUserContext->getUserId(),
                $currentPassword,
                $newPassword
            ));
        } catch (LogicException $exception) {
            return new JsonResponse([
                'errors' => $exception->toArray()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse();
    }
}
