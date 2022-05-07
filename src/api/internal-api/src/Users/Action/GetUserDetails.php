<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Action;

use App\Common\Query\QueryBus;
use App\InternalApi\Common\Auth\AuthenticatedUserContext;
use App\InternalApi\Common\Validation\Assertion;
use App\InternalApi\Users\Resources\UserFactory;
use App\Users\Application\GetUserDetails\GetUserDetailsQuery;
use App\Users\ReadModel\User\UserDetails;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetUserDetails extends AbstractController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly UserPresenter $userDetailsPresenter,
        private readonly UserFactory $userFactory,
        private readonly AuthenticatedUserContext $authenticatedUserContext
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $userId = $request->get('user_id');

        $errors = Assertion::lazy()
            ->that($userId, 'user_id')->uuid()
            ->getErrors();

        if (!empty($errors)) {
            return new JsonResponse([
                'errors' => $errors
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        /** @var UserDetails $userDetails */
        $userDetails = $this->queryBus->handle(new GetUserDetailsQuery($userId));

        $userResource = $this->userFactory->fromReadModel($userDetails, $this->authenticatedUserContext->getUserId());

        return new JsonResponse(
            $this->userDetailsPresenter->present($userResource)
        );
    }
}
