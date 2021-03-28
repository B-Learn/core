<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\ReadModel;

use App\Users\ReadModel\Authenticate\Token;
use App\Users\ReadModel\Authenticate\TokenRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final class DbalTokenRepository implements TokenRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function getTokenByEmail(string $email): ?Token
    {
        $builder = $this->connection->createQueryBuilder();

        $builder
            ->select('
                t.access_token,
                t.refresh_token,
                t.access_token_expire_at,
                t.refresh_token_expire_at
            ')
            ->from('users_auth_tokens', 't')
            ->join('t', 'users', 'u', 't.user_id = u.id')
            ->where('u.email = :EMAIL')
            ->setParameter(':EMAIL', $email)
        ;

        $statement = $builder->execute();
        $row = $statement->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return new Token(
            $row['access_token'],
            $row['refresh_token'],
            new DateTimeImmutable($row['access_token_expire_at']),
            new DateTimeImmutable($row['refresh_token_expire_at']),
        );
    }
}
