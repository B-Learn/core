<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Application\GetLanguagesList;

use App\Common\Query\QueryHandler;
use App\SharedKernel\Language\ReadModel\LanguageCollection;
use App\SharedKernel\Language\ReadModel\LanguageReadModel;

final class GetLanguagesListHandler implements QueryHandler
{
    public function __construct(private readonly LanguageReadModel $languageReadModel)
    {
    }

    public function __invoke(GetLanguagesListQuery $query): LanguageCollection
    {
        return $this->languageReadModel->getAll();
    }
}
