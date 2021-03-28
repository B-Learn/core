<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Doctrine\Mapping\Users;

use App\Users\Domain\UserId;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

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
