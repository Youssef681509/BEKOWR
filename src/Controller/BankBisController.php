<?php

namespace App\Controller;

use App\Entity\BankBis;
use App\Form\BankBisType;
use App\Repository\BankBisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bankbis')]
final class BankBisController extends AbstractController {

    public function __construct(
        private BankBisRepository $bankbisRepository,
        private PaginatorInterface $paginator,
    )
    {}

    #[Route(name: 'app_bankbis_index', methods: ['GET'])]
    public function index(BankBisRepository $bankbisRepository): Response
    {
        return $this->render('bankbis/index.html.twig', [
            'banksbis' => $bankbisRepository->findAll(),
        ]);
    }

    #[Route('/items', name: 'app_bankbis_all', methods: ['GET'])]
    public function getAll(Request $request): Response 
    {
        $banksbis = $this->paginator->paginate(
            $this->bankbisRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('bankbis/_items.html.twig', [
            'banksbis' => $banksbis
        ]);
    }

    #[Route('/new', name: 'app_bankbis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bankbis = new BankBis();
        $form = $this->createForm(BankBisType::class, $bankbis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bankbis);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_bankbis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bankbis/new.html.twig', [
            'bankbis' => $bankbis,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bankbis_show', methods: ['GET'])]
    public function show(BankBis $bankbis): Response
    {
        return $this->render('bankbis/show.html.twig', [
            'bankbis' => $bankbis,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bankbis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BankBis $bankbis, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BankBisType::class, $bankbis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();
            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_bankbis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bankbis/edit.html.twig', [
            'bankbis' => $bankbis,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bankbis_delete', methods: ['POST'])]
    public function delete(Request $request, BankBis $bankbis, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bankbis->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bankbis);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');
        }

        return $this->redirectToRoute('app_bankbis_index', [], Response::HTTP_SEE_OTHER);
    }
}
