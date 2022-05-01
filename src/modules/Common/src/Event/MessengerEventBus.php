<?php
declare(strict_types=1);

namespace App\Common\Event;

use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventBus implements EventBus
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function dispatch(Event $command): void
    {
        $this->eventBus->dispatch($command);
    }
}
