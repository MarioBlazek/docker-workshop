<?php

declare(strict_types=1);

namespace App\Controller\Movies;

use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class RetrieveCollection
{
    private MovieRepository $repository;
    private SerializerInterface $serializer;

    public function __construct(MovieRepository $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    #[Route('/api/movies', methods: ['GET'])]
    public function __invoke(): Response
    {
        $movies = $this->repository->findAll();

        if (count($movies) === 0) {
            return new JsonResponse([], Response::HTTP_OK);
        }

        return new JsonResponse(
            $this->serializer->serialize($movies, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}