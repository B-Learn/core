<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Domain;

use App\Common\Event\EventBus;
use App\Users\Domain\User;
use App\Users\Domain\UserId;
use App\Users\Domain\UserNotFoundException;
use App\Users\Domain\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry, private EventBus $eventBus)
    {
        parent::__construct($registry, User::class);
    }

    public function nextIdentity(): UserId
    {
        return new UserId(Uuid::uuid4()->toString());
    }

    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);

        foreach ($user->getEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }

    public function existsWithEmail(string $email): bool
    {
        $builder = $this->createQueryBuilder('u');

        $builder->where('u.email = :email');
        $builder->setParameter('email', $email);
        $builder->select('1');
        $query = $builder->getQuery();

        return null !== $query->getOneOrNullResult();
    }

    public function existsWithUserName(string $username): bool
    {
        $builder = $this->createQueryBuilder('u');

        $builder->where('u.username = :username');
        $builder->setParameter('username', $username);
        $builder->select('1');
        $query = $builder->getQuery();

        return null !== $query->getOneOrNullResult();
    }

    public function getByEmail(string $email): User
    {
        $user = $this->findOneBy([
            'email' => $email
        ]);

        if ($user === null) {
            throw UserNotFoundException::withCredentials();
        }

        return $user;
    }

    public function getById(UserId $id): User
    {
        $user = $this->find($id);

        if ($user === null) {
            throw UserNotFoundException::byId($id);
        }

        return $user;
    }
}
