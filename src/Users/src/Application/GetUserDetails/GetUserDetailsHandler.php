<?php
declare(strict_types=1);

namespace App\Users\Application\GetUserDetails;

use App\Common\Query\QueryHandler;
use App\Users\ReadModel\User\UserDetails;
use App\Users\ReadModel\User\UserRepository;

final class GetUserDetailsHandler implements QueryHandler
{
    public function __construct(private UserRepository $users)
    {
    }

    public function __invoke(GetUserDetailsQuery $query): UserDetails
    {
        return $this->users->getDetailsById($query->getUserId());
    }
}
