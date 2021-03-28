<?php
declare(strict_types=1);

namespace App\Common\Event;

interface EventBus
{
    public function dispatch(Event $command): void;
}
