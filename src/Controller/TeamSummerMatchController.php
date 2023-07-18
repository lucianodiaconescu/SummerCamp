<?php

namespace App\Controller;

use App\Entity\TeamSummerMatch;
use App\Form\TeamSummerMatchType;
use App\Repository\SummerMatchRepository;
use App\Repository\TeamRepository;
use App\Repository\TeamSummerMatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/team/summer/match')]
class TeamSummerMatchController extends AbstractController
{
    #[Route('/', name: 'app_team_summer_match_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $teamSummerMatches = $entityManager
            ->getRepository(TeamSummerMatch::class)
            ->findAll();
        return $this->render('team_summer_match/index.html.twig', [
            'team_summer_matches' => $teamSummerMatches,
            'message' => '',
        ]);
    }

    #[Route('/new', name: 'app_team_summer_match_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SummerMatchRepository $summerMatchRepository, TeamSummerMatchRepository $teamSummerMatchRepository): Response
    {

        $maximumMatches = $summerMatchRepository->count([]) * 2;
        $numberOfMatches = $teamSummerMatchRepository->count([]);
        $teamSummerMatch = new TeamSummerMatch();
        $form = $this->createForm(TeamSummerMatchType::class, $teamSummerMatch);
        $form->handleRequest($request);

        $match = $teamSummerMatch->getMatch();
        $numberOfMatchesPlayed = $teamSummerMatchRepository->count(['match' => $match]);

        if ($numberOfMatchesPlayed == 2){
            return $this->render('team_summer_match/index.html.twig', [
                'team_summer_matches' => $teamSummerMatchRepository->findAll(),
                'message' => 'Nu se mai pot adauga echipe la acest meci.',
            ]);
        }

        if ($numberOfMatches >= $maximumMatches) {
            return $this->render('team_summer_match/index.html.twig', [
                'team_summer_matches' => $teamSummerMatchRepository->findAll(),
                'message' => 'Nu se mai pot adauga echipe la meciuri.',
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($teamSummerMatch);
            $entityManager->flush();

            return $this->redirectToRoute('app_team_summer_match_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team_summer_match/new.html.twig', [
            'team_summer_match' => $teamSummerMatch,
            'form' => $form,
            'message' => '',
        ]);
    }

    #[Route('/{id}', name: 'app_team_summer_match_show', methods: ['GET'])]
    public function show(TeamSummerMatch $teamSummerMatch): Response
    {
        return $this->render('team_summer_match/show.html.twig', [
            'team_summer_match' => $teamSummerMatch,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_summer_match_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TeamSummerMatch $teamSummerMatch, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeamSummerMatchType::class, $teamSummerMatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_team_summer_match_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team_summer_match/edit.html.twig', [
            'team_summer_match' => $teamSummerMatch,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_summer_match_delete', methods: ['POST'])]
    public function delete(Request $request, TeamSummerMatch $teamSummerMatch, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $teamSummerMatch->getId(), $request->request->get('_token'))) {
            $entityManager->remove($teamSummerMatch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_team_summer_match_index', [], Response::HTTP_SEE_OTHER);
    }
}
