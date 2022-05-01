<?php
declare(strict_types=1);

namespace App\Common\Exception;

final class Message
{
    private string $message;
    private ?AdditionalData $data;

    public function __construct(string $message, AdditionalData $data = null)
    {
        $this->message = $message;
        $this->data = $data;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): ?AdditionalData
    {
        return $this->data;
    }
}
