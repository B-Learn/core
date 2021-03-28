<?php
declare(strict_types=1);

namespace App\Common\Event;

use DateTimeImmutable;

interface Event
{
    public function occurredAt(): DateTimeImmutable;
}
