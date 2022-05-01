<?php
declare(strict_types=1);

namespace App\Common\BuildingBlock;

use App\Common\Event\Event;

abstract class Entity
{
    /**
     * @var Event[]
     */
    private array $events = [];

    protected function publishEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    public function clearEvents(): void
    {
        $this->events = [];
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
