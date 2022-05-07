<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Application\GetLanguagesListByIds;

use App\Common\Query\Query;

final class GetLanguagesListByIdsQuery implements Query
{
    private array $ids;

    public function __construct(string ...$ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return string[]
     */
    public function getIds(): array
    {
        return $this->ids;
    }
}
