<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use App\Repository\TeamSummerMatchRepository;
use App\Entity\SummerMatch;
use App\Entity\Team;
use App\Form\SummerMatchEditType;
use App\Form\SummerMatchType;
use App\Repository\SummerMatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/summer/match')]
class SummerMatchController extends AbstractController
{
    #[Route('/', name: 'app_summer_match_index', methods: ['GET'])]
    public function index(SummerMatchRepository $summerMatchRepository, TeamSummerMatchRepository $teamSummerMatchRepository): Response
    {
        return $this->render('summer_match/index.html.twig', [
            'summer_matches' => $summerMatchRepository->findAll(),
            'team_summer_matches' => $teamSummerMatchRepository->findAll(),
            'message' => '',
        ]);
    }

    #[Route('/new', name: 'app_summer_match_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SummerMatchRepository $summerMatchRepository, TeamRepository $teamRepository, TeamSummerMatchRepository $teamSummerMatchRepository): Response
    {
        $numberOfMatchesAdded = $summerMatchRepository->count([]);
        $n = $teamRepository->count([]);

        $maxNumberOfMatches = $n * $n - $n;
        $summerMatch = new SummerMatch();
        $form = $this->createForm(SummerMatchType::class, $summerMatch);
        $form->handleRequest($request);
        if ($numberOfMatchesAdded >= $maxNumberOfMatches) {
            return $this->render('summer_match/index.html.twig', [
                'summer_matches' => $summerMatchRepository->findAll(),
                'team_summer_matches' => $teamSummerMatchRepository->findAll(),
                'message' => 'Numarul maxim de meciuri a fost atins!',
            ]);
        }



        if ($form->isSubmitted() && $form->isValid()) {
            $summerMatchRepository->save($summerMatch, true);

            return $this->redirectToRoute('app_summer_match_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('summer_match/new.html.twig', [
            'summer_match' => $summerMatch,
            'form' => $form,
            'message' => 'Numarul maxim de meciuri a fost atins!',
        ]);
    }



    #[Route('/{id}', name: 'app_summer_match_show', methods: ['GET'])]
    public function show(SummerMatch $summerMatch, TeamSummerMatchRepository $teamSummerMatchRepository): Response
    {
        return $this->render('summer_match/show.html.twig', [
            'summer_match' => $summerMatch,
            'team_summer_matches' => $teamSummerMatchRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_summer_match_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SummerMatch $summerMatch, SummerMatchRepository $summerMatchRepository): Response
    {
        $form = $this->createForm(SummerMatchEditType::class, $summerMatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $summerMatchRepository->save($summerMatch, true);

            return $this->redirectToRoute('app_summer_match_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('summer_match/edit.html.twig', [
            'summer_match' => $summerMatch,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_summer_match_delete', methods: ['POST'])]
    public function delete(Request $request, SummerMatch $summerMatch, SummerMatchRepository $summerMatchRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$summerMatch->getId(), $request->request->get('_token'))) {
            $summerMatchRepository->remove($summerMatch, true);
        }

        return $this->redirectToRoute('app_summer_match_index', [], Response::HTTP_SEE_OTHER);
    }
}
