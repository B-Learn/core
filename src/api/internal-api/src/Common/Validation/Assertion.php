<?php
declare(strict_types=1);

namespace App\InternalApi\Common\Validation;

use Assert\Assert;

final class Assertion extends Assert
{
    public static function lazy(): LazyAssertion
    {
        $lazyAssertion = new LazyAssertion();

        return $lazyAssertion
            ->setAssertClass(\get_called_class())
            ->setExceptionClass(self::$lazyAssertionExceptionClass);
    }
}
