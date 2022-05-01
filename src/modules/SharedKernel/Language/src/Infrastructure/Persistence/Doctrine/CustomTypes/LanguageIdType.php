<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Infrastructure\Persistence\Doctrine\CustomTypes;

use App\SharedKernel\Language\Domain\LanguageId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class LanguageIdType extends GuidType
{
    const Uuid = 'Language_LanguageId';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new LanguageId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getUuid();
    }

    public function getName()
    {
        return self::Uuid;
    }
}
