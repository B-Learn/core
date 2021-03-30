<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Infrastructure\Domain;

use App\SharedKernel\Language\Domain\Language;
use App\SharedKernel\Language\Domain\LanguageId;
use App\SharedKernel\Language\Domain\LanguageNotFoundException;
use App\SharedKernel\Language\Domain\LanguageRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineLanguageRepository extends ServiceEntityRepository implements LanguageRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Language::class);
    }

    public function getById(LanguageId $id): Language
    {
        $language = $this->find($id);

        if ($language === null) {
            throw LanguageNotFoundException::byId($id);
        }

        return $language;
    }
}
