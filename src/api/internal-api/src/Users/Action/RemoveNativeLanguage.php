<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Action;

use App\Common\Command\CommandBus;
use App\Common\Exception\LogicException;
use App\InternalApi\Common\Auth\AuthenticatedUserContext;
use App\InternalApi\Common\Validation\Assertion;
use App\Users\Application\RemoveNativeLanguage\RemoveNativeLanguageCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class RemoveNativeLanguage extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly AuthenticatedUserContext $loggedUserContext
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $languageId = $request->get('language_id');

        $errors = Assertion::lazy()
            ->that($languageId, 'language_id')->uuid()
            ->getErrors();

        if (!empty($errors)) {
            return new JsonResponse([
                'errors' => $errors
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->commandBus->dispatch(new RemoveNativeLanguageCommand(
                $this->loggedUserContext->getUserId(),
                $languageId
            ));
        } catch (LogicException $exception) {
            return new JsonResponse([
                'errors' => $exception->toArray()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse();
    }
}
