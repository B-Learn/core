<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Domain;

use App\Users\Domain\AuthService;
use App\Users\Domain\User;
use DateInterval;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;

final class CredentialsAuthService implements AuthService
{
    private const TABLE_NAME = 'users_auth_tokens';

    public function __construct(private Connection $connection)
    {
    }

    public function auth(User $user): void
    {
        $this->generateToken($user);
    }

    public function generateToken(User $user): void
    {
        $now = new DateTimeImmutable();

        [$accessToken, $refreshToken] = $this->tokens();

        $this->connection->delete(self::TABLE_NAME, [
            'user_id' => $user->getId()->getUuid()
        ]);

        $this->connection->insert(self::TABLE_NAME, [
            'user_id' => $user->getId()->getUuid(),
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'access_token_expire_at' => $now->add(new DateInterval('PT3H'))->format(DATE_ATOM),
            'refresh_token_expire_at' => $now->add(new DateInterval('P14D'))->format(DATE_ATOM),
        ]);
    }

    private function tokens(): array
    {
        $accessToken = Uuid::uuid4()->toString();
        $refreshToken = Uuid::uuid4()->toString();

        $builder = $this->connection->createQueryBuilder();

        $result = $builder
            ->select('1')
            ->from(self::TABLE_NAME, 't')
            ->where('t.access_token = :ACCESS_TOKEN')
            ->orWhere('t.refresh_token = :REFRESH_TOKEN')
            ->setParameter('ACCESS_TOKEN', $accessToken)
            ->setParameter('REFRESH_TOKEN', $refreshToken)
            ->executeQuery();

        if ($result->fetchAssociative() !== false) {
            return $this->tokens();
        }

        return [$accessToken, $refreshToken];
    }
}
