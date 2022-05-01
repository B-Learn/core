<?php
declare(strict_types=1);

namespace App\Common\MessengerMiddleware;

use App\Common\BuildingBlock\Entity;
use App\Common\Event\EventBus;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class DomainEventsDispatchMiddleware implements MiddlewareInterface
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

        $envelope = $stack->next()->handle($envelope, $stack);

        $this->dispatchDomainEvents($entityManager);

        return $envelope;
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
