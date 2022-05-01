<?php
declare(strict_types=1);

namespace App\Users\UI\Http\Api\GetCurrentUserDetails;

use App\Common\Auth\AuthenticatedUserContext;
use App\Common\Query\QueryBus;
use App\Users\Application\GetUserDetails\GetUserDetailsQuery;
use App\Users\ReadModel\User\UserDetails;
use App\Users\UI\Http\Api\Presenters\UserDetailsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetCurrentUserDetailsController extends AbstractController
{
    public function __construct(
        private QueryBus $queryBus,
        private AuthenticatedUserContext $authenticatedUserContext,
        private UserDetailsPresenter $userDetailsPresenter
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
