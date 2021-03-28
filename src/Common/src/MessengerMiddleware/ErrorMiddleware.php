<?php
declare(strict_types=1);

namespace App\Common\MessengerMiddleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class ErrorMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            return $stack->next()->handle($envelope, $stack);
        } catch (\Throwable $exception) {
            if ($exception instanceof HandlerFailedException) {
                $rootException = $exception->getPrevious();
            }

            throw $rootException ?? $exception;
        }
    }
}

