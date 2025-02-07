<?php

namespace App\Controller;

use App\Entity\Donor;
use App\Form\DonorType;
use App\Repository\DonorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/donor')]
final class DonorController extends AbstractController{

    public function __construct(
        private DonorRepository $donorRepository,
        private PaginatorInterface $paginator,
    ){}

    #[Route(name: 'app_donor_index', methods: ['GET'])]
    public function index(DonorRepository $donorRepository): Response
    {
        return $this->render('donor/index.html.twig', [
            'donors' => $donorRepository->findAll(),
        ]);
    }

    #[Route('/items', name: 'app_donor_all', methods: ['GET'])]
    public function getAll(Request $request): Response 
    {
        $donors = $this->paginator->paginate(
            $this->donorRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('donor/_items.html.twig', [
            'donors' => $donors,
        ]);
    }

    #[Route('/new', name: 'app_donor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $donor = new Donor();
        $form = $this->createForm(DonorType::class, $donor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($donor);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_donor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('donor/new.html.twig', [
            'donor' => $donor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_donor_show', methods: ['GET'])]
    public function show(Donor $donor): Response
    {
        return $this->render('donor/show.html.twig', [
            'donor' => $donor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_donor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Donor $donor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DonorType::class, $donor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_donor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('donor/edit.html.twig', [
            'donor' => $donor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_donor_delete', methods: ['POST'])]
    public function delete(Request $request, Donor $donor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($donor);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');
        }

        return $this->redirectToRoute('app_donor_index', [], Response::HTTP_SEE_OTHER);
    }
}
