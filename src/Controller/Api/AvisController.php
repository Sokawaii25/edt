<?php

namespace App\Controller\Api;

use App\Entity\Avis;
use App\Entity\Professeur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AvisRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route("/api/avis", name: "api_avis_")]
class AvisController extends AbstractController
{
    use ControllerHelpers;

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(AvisRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'update', methods: ['PATCH'])]
    public function editAvis(Avis $avis, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        if(is_null($avis))
            return $this->json([
                'message' => 'Ce professeur est introuvable',
            ], JsonResponse::HTTP_NOT_FOUND);
        else {

            $errors = [];
            $content = json_decode($request->getContent(), true);
            $missingProperties = $avis->updateFromArray($content);
            if (count($missingProperties) > 0) {
                $messages = [];
                foreach ($missingProperties as $property) {
                    $messages[$property] = 'Cette propriété n\'existe pas';
                }

                return $this->json($messages, JsonResponse::HTTP_BAD_REQUEST);
            }
            
            $errors = $validator->validate($avis);

            if ($errors->count() > 0) {
                return $this->json($this->formatErrors($errors), JsonResponse::HTTP_BAD_REQUEST);
            }

            $em->persist($avis);
            $em->flush();

            return $this->json([
                'message' => 'Avis modifié',
                'avis' => $avis
            ], JsonResponse::HTTP_OK);
        }
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteAvis(Avis $avis = null, EntityManagerInterface $em): JsonResponse
    {
        if (is_null($avis)) {
            return $this->json([
                'message' => 'Cet avis est introuvable',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $em->remove($avis);
        $em->flush();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
