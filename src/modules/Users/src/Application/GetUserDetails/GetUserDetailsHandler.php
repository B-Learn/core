<?php
declare(strict_types=1);

namespace App\Users\Application\GetUserDetails;

use App\Common\Query\QueryHandler;
use App\Users\ReadModel\User\UserDetails;
use App\Users\ReadModel\User\UserReadModel;

final class GetUserDetailsHandler implements QueryHandler
{
    public function __construct(private readonly UserReadModel $userReadModel)
    {
    }

    public function __invoke(GetUserDetailsQuery $query): UserDetails
    {
        return $this->userReadModel->getDetailsById($query->getUserId());
    }
}
