<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Form\BankType;
use App\Repository\BankRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CitiesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/bank')]
final class BankController extends AbstractController {

    public function __construct(
        private BankRepository $bankRepository,
        private PaginatorInterface $paginator,
    )
    {}

    #[Route('/get-cities/{countryId}', name: 'get_cities', methods: ['GET'])]
    public function getCitiesByCountry(int $countryId, CitiesRepository $citiesRepository): JsonResponse
    {
        // Trouver les villes associées au pays
        $cities = $citiesRepository->findBy(['country' => $countryId]);

        // Formater la réponse en JSON
        $data = [];
        foreach ($cities as $city) {
            $data[] = [
                'id' => $city->getId(),
                'name' => $city->getName(),
            ];
        }

        return new JsonResponse($data);
    }


    #[Route(name: 'app_bank_index', methods: ['GET'])]
    public function index(BankRepository $bankRepository): Response
    {
        return $this->render('bank/index.html.twig', [
            'banks' => $bankRepository->findAll(),
        ]);
    }

    #[Route('/items', name: 'app_bank_all', methods: ['GET'])]
    public function getAll(Request $request): Response 
    {
        $banks = $this->paginator->paginate(
            $this->bankRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('bank/_items.html.twig', [
            'banks' => $banks
        ]);
    }

    #[Route('/new', name: 'app_bank_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bank = new Bank();
        $form = $this->createForm(BankType::class, $bank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bank);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_bank_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bank/new.html.twig', [
            'bank' => $bank,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bank_show', methods: ['GET'])]
    public function show(Bank $bank): Response
    {
        return $this->render('bank/show.html.twig', [
            'bank' => $bank,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bank_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bank $bank, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BankType::class, $bank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();
            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_bank_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bank/edit.html.twig', [
            'bank' => $bank,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bank_delete', methods: ['POST'])]
    public function delete(Request $request, Bank $bank, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bank->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bank);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');
        }

        return $this->redirectToRoute('app_bank_index', [], Response::HTTP_SEE_OTHER);
    }
}
