<?php

namespace App\Controller;

use App\Entity\Beneficiary;
use App\Form\BeneficiaryType;
use App\Repository\BeneficiaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/beneficiary')]
final class BeneficiaryController extends AbstractController {

    public function __construct(
        private BeneficiaryRepository $beneficiaryRepository,
        private PaginatorInterface $paginator,
    )
    {}

    #[Route(name: 'app_beneficiary_index', methods: ['GET'])]
    public function index(BeneficiaryRepository $beneficiaryRepository): Response
    {
        return $this->render('beneficiary/index.html.twig', [
            'beneficiaries' => $beneficiaryRepository->findAll(),
        ]);
    }

    #[Route('/items', name: 'app_beneficiary_all', methods: ['GET'])]
    public function getAll(Request $request): Response 
    {
        $beneficiaries = $this->paginator->paginate(
            $this->beneficiaryRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('beneficiary/_items.html.twig',[
            'beneficiaries' => $beneficiaries,
        ]);
    }

    #[Route('/new', name: 'app_beneficiary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $beneficiary = new Beneficiary();
        $form = $this->createForm(BeneficiaryType::class, $beneficiary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($beneficiary);
            $entityManager->flush();
   
            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_beneficiary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('beneficiary/new.html.twig', [
            'beneficiary' => $beneficiary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_beneficiary_show', methods: ['GET'])]
    public function show(Beneficiary $beneficiary): Response
    {
        return $this->render('beneficiary/show.html.twig', [
            'beneficiary' => $beneficiary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_beneficiary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Beneficiary $beneficiary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BeneficiaryType::class, $beneficiary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_beneficiary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('beneficiary/edit.html.twig', [
            'beneficiary' => $beneficiary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_beneficiary_delete', methods: ['POST'])]
    public function delete(Request $request, Beneficiary $beneficiary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$beneficiary->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($beneficiary);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');
        }

        return $this->redirectToRoute('app_beneficiary_index', [], Response::HTTP_SEE_OTHER);
    }
}
