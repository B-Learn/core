<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Application\GetLanguagesListByIds;

use App\Common\Query\QueryHandler;
use App\SharedKernel\Language\ReadModel\LanguageCollection;
use App\SharedKernel\Language\ReadModel\LanguageReadModel;

final class GetLanguagesListByIdsHandler implements QueryHandler
{
    public function __construct(private readonly LanguageReadModel $languageReadModel)
    {
    }

    public function __invoke(GetLanguagesListByIdsQuery $query): LanguageCollection
    {
        return $this->languageReadModel->getAllByIds(...$query->getIds());
    }
}
