<?php

namespace App\Controller\Api;

use App\Repository\CoursRepository;
use App\Entity\Cours;
use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/cours', name: 'api_cours_')]
class CoursController extends AbstractController
{
    use ControllerHelpers;

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

    #[Route('/{id}/avis', name: 'new_avis', methods: ['POST'])]
    public function newAvis(Cours $cours = null, Request $request, ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse
    {
        if(is_null($cours))
            return $this->json([
                'message' => 'Ce cours est introuvable',
            ], JsonResponse::HTTP_NOT_FOUND);

        $content = json_decode($request->getContent(), true);
        $avis = (new Avis())
            ->fromArray($content)
            ->setCours($cours);

        $errors = $validator->validate($avis, null, ['Default', 'avisCours']);

        if ($errors->count() > 0)
            return $this->json($this->formatErrors($errors), JsonResponse::HTTP_BAD_REQUEST);

        $em->persist($avis);
        $em->flush();

        return $this->json($avis, JsonResponse::HTTP_CREATED);
    }
}
