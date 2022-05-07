<?php
declare(strict_types=1);

namespace App\Users\ReadModel\User;

interface UserReadModel
{
    public function getDetailsById(string $userId): UserDetails;
}
