<?php
declare(strict_types=1);

namespace App\InternalApi\Users\Resources;

use App\Common\Query\QueryBus;
use App\InternalApi\Languages\Resources\LanguageFactory;
use App\SharedKernel\Language\Application\GetLanguagesListByIds\GetLanguagesListByIdsQuery;
use App\SharedKernel\Language\ReadModel\LanguageCollection;
use App\Users\ReadModel\User\UserDetails;

class UserFactory
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly LanguageFactory $languageFactory
    ) {
    }

    public function fromReadModel(UserDetails $userDetails, ?string $loggedUserId): User
    {
        [$nativeLanguages, $studyingLanguages] = $this->fetchLanguages($userDetails);

        return new User(
            $userDetails->getId(),
            $userDetails->getUsername(),
            $userDetails->getDisplayName(),
            $userDetails->getId() === $loggedUserId
                ? $userDetails->getEmail()
                : null,
            $nativeLanguages,
            $studyingLanguages
        );
    }

    private function fetchLanguages(UserDetails $userDetails): array
    {
        $languageIds = array_unique(array_merge($userDetails->getNativeLanguagesIds(), $userDetails->getStudyingLanguagesIds()));

        if (empty($languageIds)) {
            return [[], []];
        }

        /** @var LanguageCollection $languages */
        $languages = $this->queryBus->handle(new GetLanguagesListByIdsQuery(...$languageIds));

        $nativeLanguages = [];
        $studyingLanguages = [];

        foreach ($languages->getLanguages() as $language) {
            foreach ($userDetails->getNativeLanguagesIds() as $nativeLanguageId) {
                if ($language->getId() === $nativeLanguageId) {
                    $nativeLanguages[] = $this->languageFactory->fromReadModel($language);
                }
            }

            foreach ($userDetails->getStudyingLanguagesIds() as $studyingLanguageId) {
                if ($language->getId() === $studyingLanguageId) {
                    $studyingLanguages[] = $this->languageFactory->fromReadModel($language);
                }
            }
        }

        return [$nativeLanguages, $studyingLanguages];
    }
}
