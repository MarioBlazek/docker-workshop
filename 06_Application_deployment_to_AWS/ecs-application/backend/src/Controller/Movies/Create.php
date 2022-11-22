<?php

declare(strict_types=1);

namespace App\Controller\Movies;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

final class Create
{
    private SerializerInterface $serializer;
    private MovieRepository $repository;

    public function __construct(SerializerInterface $serializer, MovieRepository $repository)
    {
        $this->serializer = $serializer;
        $this->repository = $repository;
    }

    #[Route('/api/movies', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $body = $request->getContent();

        try {
            $movie = $this->serializer->deserialize($body, Movie::class, 'json', [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]);
            $this->repository->save($movie, true);
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'message' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST
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