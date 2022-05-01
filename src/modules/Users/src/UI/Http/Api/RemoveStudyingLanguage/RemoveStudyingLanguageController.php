<?php
declare(strict_types=1);

namespace App\Users\UI\Http\Api\RemoveStudyingLanguage;

use App\Common\Auth\AuthenticatedUserContext;
use App\Common\Command\CommandBus;
use App\Common\Exception\LogicException;
use App\Common\Validation\Assertion;
use App\Users\Application\RemoveStudyingLanguage\RemoveStudyingLanguageCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RemoveStudyingLanguageController
{
    public function __construct(private CommandBus $commandBus, private AuthenticatedUserContext $loggedUserContext)
    {
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
            $this->commandBus->dispatch(new RemoveStudyingLanguageCommand(
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
