<?php
declare(strict_types=1);

namespace App\Users\Domain;

interface UserRepository
{
    public function nextIdentity(): UserId;
    public function add(User $user): void;
    public function existsWithEmail(string $email): bool;
    public function existsWithUserName(string $username): bool;

    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email): User;

    /**
     * @throws UserNotFoundException
     */
    public function getById(UserId $id): User;
}
