<?php
declare(strict_types=1);

namespace App\InternalApi\Common\Validation;

use Assert\LazyAssertion as BaseLazyAssertion;
use Assert\LazyAssertionException;

final class LazyAssertion extends BaseLazyAssertion
{
    public function getErrors(): array
    {
        $errors = [];

        try {
            $this->verifyNow();
        } catch (LazyAssertionException $exception) {
            foreach ($exception->getErrorExceptions() as $errorException) {
                $errors[] = [
                    'filed' => $errorException->getPropertyPath(),
                    'message' => $errorException->getMessage()
                ];
            }
        }

        return $errors;
    }
}
