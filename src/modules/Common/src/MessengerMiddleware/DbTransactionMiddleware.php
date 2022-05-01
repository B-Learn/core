<?php
declare(strict_types=1);

namespace App\Common\MessengerMiddleware;

use App\Common\BuildingBlock\Entity;
use App\Common\Event\EventBus;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DbTransactionMiddleware implements MiddlewareInterface
{
    public function __construct(private ManagerRegistry $managerRegistry, private EventBus $eventBus)
    {
    }

    final public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            $entityManager = $this->managerRegistry->getManager();
        } catch (\InvalidArgumentException $e) {
            throw new UnrecoverableMessageHandlingException($e->getMessage(), 0, $e);
        }

        $entityManager->getConnection()->beginTransaction();
        try {
            $envelope = $stack->next()->handle($envelope, $stack);

            $this->dispatchDomainEvents($entityManager);

            $entityManager->flush();
            $entityManager->getConnection()->commit();

            return $envelope;
        } catch (\Throwable $exception) {
            $entityManager->getConnection()->rollBack();

            if ($exception instanceof HandlerFailedException) {
                // Remove all HandledStamp from the envelope so the retry will execute all handlers again.
                // When a handler fails, the queries of allegedly successful previous handlers just got rolled back.
                throw new HandlerFailedException($exception->getEnvelope()->withoutAll(HandledStamp::class), $exception->getNestedExceptions());
            }

            throw $exception;
        }
    }

    private function dispatchDomainEvents(ObjectManager $entityManager)
    {
        $domainEvents = [];

        foreach ($entityManager->getUnitOfWork()->getIdentityMap() as $className => $entities) {
            foreach($entities as $entity) {
                if ($entity instanceof Entity) {
                    foreach ($entity->getEvents() as $event) {
                        $domainEvents[] = $event;
                    }
                }
            }
        }

        foreach ($entityManager->getUnitOfWork()->getIdentityMap() as $className => $entities) {
            foreach($entities as $entity) {
                if ($entity instanceof Entity) {
                    $entity->clearEvents();
                }
            }
        }

        foreach ($domainEvents as $domainEvent) {
            $this->eventBus->dispatch($domainEvent);
        }
    }
}
