<?php

namespace App\Controller\Api;

use App\Repository\CoursRepository;
use App\Entity\Cours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cours', name: 'api_cours_')]
class CoursController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(CoursRepository $repository): JsonResponse
    {
        $cours = $repository->findAll();
        return $this->json($cours, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Cours $cours = null): JsonResponse
    {
        return is_null($cours) 
            ? $this->json([
                'message' => 'Ce cours est introuvable',
            ], JsonResponse::HTTP_NOT_FOUND)
            : $this->json($cours, JsonResponse::HTTP_OK);
    }

    #[Route('/date/{date}', name: 'date', methods: ['GET'])]
    public function date(CoursRepository $repository, string $date): JsonResponse
    {
        $cours = $repository->findByDate($date);
        return $this->json($cours, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}/avis', name: 'avis', methods: ['GET'])]
    public function avis(Cours $cours = null): JsonResponse
    {
        return is_null($cours) 
            ? $this->json([
                'message' => 'Ce cours est introuvable',
            ], JsonResponse::HTTP_NOT_FOUND)
            : $this->json($cours->getAvis()->toArray(), JsonResponse::HTTP_OK);
    }
}
