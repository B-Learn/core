<?php
declare(strict_types=1);

namespace App\InternalApi\Languages\Action;

use App\Common\Query\QueryBus;
use App\InternalApi\Common\Presenter\ResponsePresenter;
use App\InternalApi\Languages\Resources\LanguageFactory;
use App\SharedKernel\Language\Application\GetLanguagesList\GetLanguagesListQuery;
use App\SharedKernel\Language\ReadModel\Language;
use App\SharedKernel\Language\ReadModel\LanguageCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class LanguageList extends AbstractController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly LanguageFactory $languageFactory,
        private readonly ResponsePresenter $responsePresenter
    ) {
    }

    public function __invoke(): Response
    {
        /** @var LanguageCollection $list */
        $list = $this->queryBus->handle(new GetLanguagesListQuery());

        $resources = array_map(fn (Language $l) => $this->languageFactory->fromReadModel($l), $list->getLanguages());

        return $this->responsePresenter->present($resources);
    }
}
