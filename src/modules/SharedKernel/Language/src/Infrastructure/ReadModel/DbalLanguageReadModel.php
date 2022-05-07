<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Infrastructure\ReadModel;

use App\SharedKernel\Language\ReadModel\Language;
use App\SharedKernel\Language\ReadModel\LanguageCollection;
use App\SharedKernel\Language\ReadModel\LanguageReadModel;
use Doctrine\DBAL\Connection;

final class DbalLanguageReadModel implements LanguageReadModel
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function getAll(): LanguageCollection
    {
        $builder = $this->connection->createQueryBuilder();

        $builder
            ->select('*')
            ->from('languages', 'l')
        ;

        $rows = $builder->executeQuery()->fetchAllAssociative();

        $result = [];

        foreach ($rows as $row) {
            $result[] = $this->fromRow($row);
        }

        return new LanguageCollection(...$result);
    }

    public function getAllByIds(string ...$ids): LanguageCollection
    {
        $builder = $this->connection->createQueryBuilder();

        $builder
            ->select('*')
            ->from('languages', 'l')
            ->where('l.id IN (:IDS)')
            ->setParameter('IDS', $ids, Connection::PARAM_STR_ARRAY)
        ;

        $rows = $builder->executeQuery()->fetchAllAssociative();

        $result = [];

        foreach ($rows as $row) {
            $result[] = $this->fromRow($row);
        }

        return new LanguageCollection(...$result);
    }

    private function fromRow(array $row): Language
    {
        return new Language(
            $row['id'],
            $row['name'],
            $row['short_name'],
        );
    }
}
