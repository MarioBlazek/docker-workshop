<?php

declare(strict_types=1);

namespace App\Controller\Movies;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class Get
{
    private MovieRepository $repository;
    private SerializerInterface $serializer;

    public function __construct(MovieRepository $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    #[Route('/api/movies/{id}', methods: ['GET'])]
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

        return new JsonResponse(
            $this->serializer->serialize($movie, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}