<?php
declare(strict_types=1);

namespace App\Users\UI\Http\Api\GetUserDetails;

use App\Common\Query\QueryBus;
use App\Common\Validation\Assertion;
use App\Users\Application\GetUserDetails\GetUserDetailsQuery;
use App\Users\ReadModel\User\UserDetails;
use App\Users\UI\Http\Api\Presenters\UserDetailsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetUserDetailsController extends AbstractController
{
    public function __construct(
        private QueryBus $queryBus,
        private UserDetailsPresenter $userDetailsPresenter
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

        return new JsonResponse(
            $this->userDetailsPresenter->present($userDetails)
        );
    }
}
