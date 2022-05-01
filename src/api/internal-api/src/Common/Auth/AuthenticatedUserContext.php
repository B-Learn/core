<?php
declare(strict_types=1);

namespace App\InternalApi\Common\Auth;

interface AuthenticatedUserContext
{
    public function getUserId(): string;
}
