<?php

namespace App\Controller;

use App\Entity\Claim;
use App\Form\ClaimType;
use App\Repository\ClaimRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/claim')]
final class ClaimController extends AbstractController {

    public function __construct(
        private ClaimRepository $claimRepository,
        private PaginatorInterface $paginator,
    )
    {}

    #[Route(name: 'app_claim_index', methods: ['GET'])]
    public function index(ClaimRepository $claimRepository): Response
    {
        return $this->render('claim/index.html.twig', [
            'claims' => $claimRepository->findAll(),
        ]);
    }

    #[Route('/items', name: 'app_claim_all', methods: ['GET'])]
    public function getAll(Request $request): Response {

        $claims = $this->paginator->paginate(
            $this->claimRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('claim/_items.html.twig', [
            'claims' => $claims
        ]);
    }

    #[Route('/new', name: 'app_claim_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $claim = new Claim();
        $form = $this->createForm(ClaimType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($claim);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_claim_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('claim/new.html.twig', [
            'claim' => $claim,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_claim_show', methods: ['GET'])]
    public function show(Claim $claim): Response
    {
        return $this->render('claim/show.html.twig', [
            'claim' => $claim,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_claim_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Claim $claim, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClaimType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_claim_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('claim/edit.html.twig', [
            'claim' => $claim,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_claim_delete', methods: ['POST'])]
    public function delete(Request $request, Claim $claim, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$claim->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($claim);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');
        }

        return $this->redirectToRoute('app_claim_index', [], Response::HTTP_SEE_OTHER);
    }
}
