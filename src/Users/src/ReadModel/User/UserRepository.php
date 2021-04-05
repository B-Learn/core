<?php
declare(strict_types=1);

namespace App\Users\ReadModel\User;

interface UserRepository
{
    public function getDetailsById(string $userId): UserDetails;
}
