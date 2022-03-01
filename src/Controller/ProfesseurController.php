<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
use App\Entity\Professeur;

#[Route("/professeurs", name: "professeurs_")]
class ProfesseurController extends AbstractController
{
    #[Route('', name: 'list')]
    public function liste(ProfesseurRepository $repository): Response
    {
        $professeurs = $repository->findAll();

        return $this->render('professeurs/index.html.twig', [
            'professeurs' => $professeurs,
        ]);
    }

    #[Route('/new', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $professeur = new Professeur;
        $form =  $this->createForm(ProfesseurType::class, $professeur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professeur = $form->getData();
            $em->persist($professeur);
            $em->flush();

            return $this->redirectToRoute('professeurs_list');
        }

        return $this->render('professeurs/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Professeur $professeur, Request $request, EntityManagerInterface $em): Response
    {
        $form =  $this->createForm(ProfesseurType::class, $professeur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professeur = $form->getData();
            $em->persist($professeur);
            $em->flush();

            return $this->redirectToRoute('professeurs_list');
        }

        return $this->render('professeurs/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['GET'])]
    public function delete(Professeur $professeur, EntityManagerInterface $em): Response
    {
        $em->remove($professeur);
        $em->flush();
        return $this->render('professeurs/delete.html.twig', [
            'professeur' => $professeur,
        ]);
    }
}
