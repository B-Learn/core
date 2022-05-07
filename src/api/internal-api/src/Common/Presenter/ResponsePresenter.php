<?php
declare(strict_types=1);

namespace App\InternalApi\Common\Presenter;

use Symfony\Component\HttpFoundation\Response;

interface ResponsePresenter
{
    public function present(
        mixed $data,
        int $status = Response::HTTP_OK,
        array $headers = []
    ): Response;
}
