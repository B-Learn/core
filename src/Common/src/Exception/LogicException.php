<?php
declare(strict_types=1);

namespace App\Common\Exception;

use Exception;
use Throwable;

abstract class LogicException extends Exception
{
    /**
     * @var Message[]
     */
    private array $messages;

    public function __construct(array $messages, int $code, Throwable $previous = null)
    {
        $this->messages = $messages;

        parent::__construct($this->messages[0]->getMessage(), $code, $previous);
    }

    abstract public function contextBasicCode(): int;

    public function toArray(): array
    {
        $result = [];

        foreach ($this->messages as $message) {
            $data = $message->getData();

            $payload = [
                'message' => $message->getMessage(),
                'code' => $this->contextBasicCode() + $this->getCode(),
                'data' => null
            ];

            if ($data !== null && !empty($data->getItems())) {
                $payload['data'] = [];

                foreach ($data->getItems() as $dataItem) {
                    $payload['data'][$dataItem->getKey()] = $dataItem->getValue();
                }
            }

            $result[] = $payload;
        }

        return $result;
    }
}
