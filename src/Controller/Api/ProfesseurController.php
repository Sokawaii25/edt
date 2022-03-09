<?php

namespace App\Controller\Api;

use App\Entity\Avis;
use App\Entity\Professeur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProfesseurRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route("/api/professeurs", name: "api_professeurs_")]
class ProfesseurController extends AbstractController
{
    use ControllerHelpers;

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(ProfesseurRepository $repository): JsonResponse
    {
        $professeurs = $repository->findAll();

        // $response = new Response;
        // $response->setStatusCode(Response::HTTP_OK);
        // $response->headers->set('Content-Type', 'application/json');
        // $response->setContent(json_encode(array_map(fn ($professeur) => $professeur->toArray(), $professeurs)));

        // return $response;

        return $this->json($professeurs, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Professeur $professeur = null): JsonResponse
    {
        return is_null($professeur) 
            ? $this->json([
                'message' => 'Ce professeur est introuvable',
            ], JsonResponse::HTTP_NOT_FOUND)
            : $this->json($professeur, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}/avis', name: 'avis', methods: ['GET'])]
    public function avis(Professeur $professeur = null): JsonResponse
    {
        return is_null($professeur) 
            ? $this->json([
                'message' => 'Ce professeur est introuvable',
            ], JsonResponse::HTTP_NOT_FOUND)
            : $this->json($professeur->getAvis()->toArray(), JsonResponse::HTTP_OK);
    }

    #[Route('/{id}/avis', name: 'new_avis', methods: ['POST'])]
    public function newAvis(Professeur $professeur = null, Request $request, ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse
    {
        if(is_null($professeur))
            return $this->json([
                'message' => 'Ce professeur est introuvable',
            ], JsonResponse::HTTP_NOT_FOUND);
        
        $content = json_decode($request->getContent(), true);
        $avis = (new Avis)
            ->fromArray($content)
            ->setProfesseur($professeur);
        
        $errors = $validator->validate($avis, null, ['Default', 'avisProfesseur']);

        if ($errors->count() > 0) {
            return $this->json($this->formatErrors($errors), JsonResponse::HTTP_BAD_REQUEST);
        }

        $em->persist($avis);
        $em->flush();

        return $this->json([
            'message' => 'Avis créé',
            'avis' => $avis
        ], JsonResponse::HTTP_CREATED);
    }
}
