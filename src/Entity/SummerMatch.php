<?php

namespace App\Entity;

use App\Repository\SummerMatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SummerMatchRepository::class)]
class SummerMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $StartDate = null;

    #[ORM\ManyToOne(targetEntity: TeamSummerMatch::class, inversedBy: 'match')]
    private $teamSummerMatch = null;

    #[ORM\ManyToOne(inversedBy: 'team_id')]
    private ?Team $winner_id = null;


    public function __construct()
    {
        $this->teamSummerMatch = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?string
    {
        return $this->StartDate;
    }

    public function setStartDate(string $StartDate): static
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    /**
     * @return Collection|TeamSummerMatch[]
     */
    public function getTeamSummerMatch(): Collection
    {
        return $this->teamSummerMatch;
    }

    /**
     * @param TeamSummerMatch $teamSummerMatch
     */
    public function setTeamSummerMatch(TeamSummerMatch $teamSummerMatch): void
    {
        $this->teamSummerMatch = $teamSummerMatch;
    }



    public function getWinnerId(): ?Team
    {
        return $this->winner_id;
    }

    public function setWinnerId(?Team $winner_id): static
    {
        $this->winner_id = $winner_id;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}