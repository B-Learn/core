<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Action;

use App\Common\Query\QueryBus;
use App\InternalApi\Common\Auth\AuthenticatedUserContext;
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
        private readonly UserDetailsPresenter $userDetailsPresenter
    ) {
    }

    public function __invoke(): Response
    {
        /** @var UserDetails $userDetails */
        $userDetails = $this->queryBus->handle(new GetUserDetailsQuery(
            $this->authenticatedUserContext->getUserId(),
            true
        ));

        return new JsonResponse(
            $this->userDetailsPresenter->present($userDetails)
        );
    }
}
