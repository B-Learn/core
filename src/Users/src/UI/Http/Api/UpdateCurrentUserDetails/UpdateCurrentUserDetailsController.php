<?php
declare(strict_types=1);

namespace App\Users\UI\Http\Api\UpdateCurrentUserDetails;

use App\Common\Auth\AuthenticatedUserContext;
use App\Common\Command\CommandBus;
use App\Common\Exception\LogicException;
use App\Common\Validation\Assertion;
use App\Users\Application\UpdateCurrentUserDetails\UpdateCurrentUserDetailsCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UpdateCurrentUserDetailsController extends AbstractController
{
    public function __construct(private CommandBus $commandBus, private AuthenticatedUserContext $loggedUserContext)
    {
    }

    public function __invoke(Request $request): Response
    {
        $username = $request->get('username');
        $displayName = $request->get('display_name');

        $errors = Assertion::lazy()
            ->that($username, 'username')->nullOr()->minLength(3)->maxLength(32)
            ->that($displayName, 'display_name')->nullOr()->minLength(2)->maxLength(64)
            ->getErrors();

        if (!empty($errors)) {
            return new JsonResponse([
                'errors' => $errors
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->commandBus->dispatch(new UpdateCurrentUserDetailsCommand(
                $this->loggedUserContext->getUserId(),
                $username,
                $displayName
            ));
        } catch (LogicException $exception) {
            return new JsonResponse([
                'errors' => $exception->toArray()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse();
    }
}
