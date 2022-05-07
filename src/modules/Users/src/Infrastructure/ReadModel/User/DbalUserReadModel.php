<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\ReadModel\User;

use App\Users\Domain\UserId;
use App\Users\Domain\UserNotFoundException;
use App\Users\ReadModel\User\UserDetails;
use App\Users\ReadModel\User\UserReadModel;
use Doctrine\DBAL\Connection;

final class DbalUserReadModel implements UserReadModel
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function getDetailsById(string $userId): UserDetails
    {
        $builder = $this->connection->createQueryBuilder();

        $builder
            ->select(
                'u.id',
                'u.username',
                'u.display_name',
                'u.email',
                'GROUP_CONCAT(unl.language_id) as native_languages',
                'GROUP_CONCAT(usl.language_id) as studying_languages'
            )
            ->from('users', 'u')
            ->leftJoin('u', 'users_native_languages', 'unl', 'unl.user_id = u.id')
            ->leftJoin('u', 'users_studying_languages', 'usl', 'usl.user_id = u.id')
            ->where('u.id = :USER_ID')
            ->setParameter('USER_ID', $userId)
        ;

        $row = $builder->executeQuery()->fetchAssociative();

        if ($row === false) {
            throw UserNotFoundException::byId(new UserId($userId));
        }

        return new UserDetails(
            $row['id'],
            $row['email'] ?? null,
            $row['username'],
            $row['display_name'],
            $this->getLanguages($row['native_languages'] ?? ''),
            $this->getLanguages($row['studying_languages'] ?? '')
        );
    }

    private function getLanguages(string $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        return explode(',', $ids);
    }
}
