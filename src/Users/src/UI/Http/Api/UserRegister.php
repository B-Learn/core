<?php
declare(strict_types=1);

namespace App\Users\UI\Http\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UserRegister extends AbstractController
{
    public function __invoke()
    {
        return new JsonResponse([
            'test' => 'ok'
        ]);
    }
}
