<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Doctrine\CustomTypes;

use App\Users\Domain\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UserIdType extends GuidType
{
    const Uuid = 'Users_UserId';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserId($value);
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
