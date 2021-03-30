<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Application\GetLanguagesList;

use App\Common\Query\QueryHandler;
use App\SharedKernel\Language\ReadModel\LanguageCollection;
use App\SharedKernel\Language\ReadModel\LanguageRepository;

final class GetLanguagesListHandler implements QueryHandler
{
    private LanguageRepository $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function __invoke(GetLanguagesListQuery $query): LanguageCollection
    {
        return $this->languageRepository->getAll();
    }
}
