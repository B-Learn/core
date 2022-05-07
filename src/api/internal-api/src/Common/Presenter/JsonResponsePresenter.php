<?php
declare(strict_types=1);

namespace App\InternalApi\Common\Presenter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class JsonResponsePresenter implements ResponsePresenter
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function present(
        mixed $data,
        int $status = Response::HTTP_OK,
        array $headers = []
    ): Response {
        return new JsonResponse(
            $this->serializer->serialize($data, 'json'),
            $status,
            $headers,
            true
        );
    }
}
