<?php
declare(strict_types=1);

namespace App\InternalApi\Languages\Action;

use App\Common\Query\QueryBus;
use App\SharedKernel\Language\Application\GetLanguagesList\GetLanguagesListQuery;
use App\SharedKernel\Language\ReadModel\Language;
use App\SharedKernel\Language\ReadModel\LanguageCollection;
use App\SharedKernel\Language\UI\Http\Api\Presenters\LanguagePresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LanguageList extends AbstractController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly LanguagePresenter $languagePresenter
    ) {
    }

    public function __invoke(): JsonResponse
    {
        /** @var LanguageCollection $list */
        $list = $this->queryBus->handle(new GetLanguagesListQuery());

        return new JsonResponse($this->present($list));
    }

    private function present(LanguageCollection $list): array
    {
        return [
            'data' => array_map(
                fn (Language $language) => $this->languagePresenter->present($language),
                $list->getLanguages()
            )
        ];
    }
}
