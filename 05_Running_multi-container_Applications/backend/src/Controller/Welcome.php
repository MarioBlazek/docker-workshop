<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class Welcome
{
    #[Route('/', methods: ['GET'])]
    public function __invoke(): Response
    {
        return new JsonResponse(
            "Welcome to Movie App!",
            Response::HTTP_OK,
        );
    }
}