<?php
declare(strict_types=1);

namespace App\Users\Domain;

interface AuthService
{
    public function auth(User $user): void;
}
