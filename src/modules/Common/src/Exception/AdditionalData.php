<?php
declare(strict_types=1);

namespace App\Common\Exception;

final class AdditionalData
{
    /**
     * @var DataItem[]
     */
    private array $items = [];

    public function add(DataItem $item)
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
