<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Action;

use App\Common\Query\QueryBus;
use App\InternalApi\Common\Auth\AuthenticatedUserContext;
use App\InternalApi\Users\Resources\UserFactory;
use App\Users\Application\GetUserDetails\GetUserDetailsQuery;
use App\Users\ReadModel\User\UserDetails;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetCurrentUserDetails extends AbstractController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly AuthenticatedUserContext $authenticatedUserContext,
        private readonly UserPresenter $userDetailsPresenter,
        private readonly UserFactory $userFactory
    ) {
    }

    public function __invoke(): Response
    {
        $loggedUserId = $this->authenticatedUserContext->getUserId();

        /** @var UserDetails $userDetails */
        $userDetails = $this->queryBus->handle(new GetUserDetailsQuery($loggedUserId));

        $userResource = $this->userFactory->fromReadModel($userDetails, $loggedUserId);

        return new JsonResponse(
            $this->userDetailsPresenter->present($userResource)
        );
    }
}
