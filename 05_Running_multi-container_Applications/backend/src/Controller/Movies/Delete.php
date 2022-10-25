<?php

declare(strict_types=1);

namespace App\Controller\Movies;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class Delete
{
    private MovieRepository $repository;

    public function __construct(MovieRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/api/movies/{id}', methods: ['DELETE'])]
    public function __invoke(int $id): Response
    {
        $movie = $this->repository->find($id);

        if (!$movie instanceof Movie) {
            return new JsonResponse(
                [
                    'message' => sprintf("Movie with #%d not found", $id)
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        $this->repository->remove($movie, true);

        return new JsonResponse(
            [
                'message' => 'Removed successfully',
            ],
            Response::HTTP_OK
        );
    }
}