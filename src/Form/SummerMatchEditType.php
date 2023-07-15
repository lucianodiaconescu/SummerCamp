<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TeamSummerMatchRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\SummerMatch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Team;


class SummerMatchEditType extends SummerMatchType
{
    private EntityManagerInterface $entityManager;
    private TeamSummerMatchRepository $teamSummerMatchRepository;

    public function __construct(EntityManagerInterface $entityManager, TeamSummerMatchRepository $teamSummerMatchRepository)
    {
        $this->entityManager = $entityManager;
        $this->teamSummerMatchRepository = $teamSummerMatchRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate')
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                if ($data instanceof SummerMatch) {
                    $match = $data;
                    $teamSummerMatches = $this->teamSummerMatchRepository->findBy(['match' => $match]);
                    $teams = [];

                    foreach ($teamSummerMatches as $teamSummerMatch) {
                        $team = $teamSummerMatch->getTeam();
                        $teams[$teamSummerMatch->getId()] = $team;
                    }

                    $form->add('winner_id', EntityType::class, [
                        'class' => \App\Entity\Team::class,
                        'choice_label' => 'NumeEchipa',
                        'choices' => $teams,
                        'choice_value' => 'id',
                        'required' => false,
                        'placeholder' => 'Winner!',
                    ]);
                }
            });
    }
}