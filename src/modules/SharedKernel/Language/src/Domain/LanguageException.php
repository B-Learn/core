<?php
declare(strict_types=1);

namespace App\SharedKernel\Language\Domain;

use App\Common\Exception\LogicException;

abstract class LanguageException extends LogicException
{
    protected const LANGUAGE_NOT_FOUND = 1;

    final public function contextBasicCode(): int
    {
        return 110_000;
    }
}
