<?php

namespace App\Controller\Donation;

use App\Entity\Countries;
use App\Form\CountriesType;
use App\Repository\CountriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/donation/countries')]
final class CountriesController extends AbstractController{

    public function __construct(
        private PaginatorInterface $paginator,
        private CountriesRepository $countriesRepository,
    ){}

    #[Route(name: 'app_donation_countries_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('donation/countries/index.html.twig');
    }

    #[Route('/items', name: 'app_countries_all', methods: ['GET'])]
    public function getAll(Request $request, ): Response {

        $countries = $this->paginator->paginate(
            $this->countriesRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('donation/countries/_items.html.twig', [
            'countries' => $countries,
        ]);
    }

    #[Route('/new', name: 'app_donation_countries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $country = new Countries();
        $form = $this->createForm(CountriesType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($country);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_donation_countries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('donation/countries/new.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_donation_countries_show', methods: ['GET'])]
    public function show(Countries $country): Response
    {
        return $this->render('donation/countries/show.html.twig', [
            'country' => $country,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_donation_countries_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Countries $country, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CountriesType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');

            return $this->redirectToRoute('app_donation_countries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('donation/countries/edit.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_donation_countries_delete', methods: ['POST'])]
    public function delete(Request $request, Countries $country, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$country->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($country);
            $entityManager->flush();

            $this->addFlash('success', 'opération réussi.');
        }

        return $this->redirectToRoute('app_donation_countries_index', [], Response::HTTP_SEE_OTHER);
    }
}
