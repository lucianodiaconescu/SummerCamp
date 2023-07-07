<?php

namespace App\Controller;

use App\Entity\TeamMembers;
use App\Form\TeamMembersType;
use App\Repository\TeamMembersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/team/members')]
class TeamMembersController extends AbstractController
{
    #[Route('/', name: 'app_team_members_index', methods: ['GET'])]
    public function index(TeamMembersRepository $teamMembersRepository): Response
    {
        return $this->render('team_members/index.html.twig', [
            'team_members' => $teamMembersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_team_members_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeamMembersRepository $teamMembersRepository): Response
    {
        $teamMember = new TeamMembers();
        $form = $this->createForm(TeamMembersType::class, $teamMember);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamMembersRepository->save($teamMember, true);

            return $this->redirectToRoute('app_team_members_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team_members/new.html.twig', [
            'team_member' => $teamMember,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_members_show', methods: ['GET'])]
    public function show(TeamMembers $teamMember): Response
    {
        return $this->render('team_members/show.html.twig', [
            'team_member' => $teamMember,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_members_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TeamMembers $teamMember, TeamMembersRepository $teamMembersRepository): Response
    {
        $form = $this->createForm(TeamMembersType::class, $teamMember);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamMembersRepository->save($teamMember, true);

            return $this->redirectToRoute('app_team_members_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team_members/edit.html.twig', [
            'team_member' => $teamMember,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_members_delete', methods: ['POST'])]
    public function delete(Request $request, TeamMembers $teamMember, TeamMembersRepository $teamMembersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teamMember->getId(), $request->request->get('_token'))) {
            $teamMembersRepository->remove($teamMember, true);
        }

        return $this->redirectToRoute('app_team_members_index', [], Response::HTTP_SEE_OTHER);
    }
}
