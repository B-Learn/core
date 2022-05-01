<?php
declare(strict_types=1);

namespace App\Common\Auth;

interface AuthenticatedUserContext
{
    public function getUserId(): string;
}
