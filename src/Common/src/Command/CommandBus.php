<?php
declare(strict_types=1);

namespace App\Common\Command;

use App\Common\Exception\LogicException;

interface CommandBus
{
    /**
     * @throws LogicException
     */
    public function dispatch(Command $command): void;
}
