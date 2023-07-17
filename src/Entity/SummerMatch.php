<?php

namespace App\Entity;

use App\Repository\SummerMatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TeamSummerMatch;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\VarDumper\Cloner\Data;

#[UniqueEntity('StartDate')]
#[ORM\Entity(repositoryClass: SummerMatchRepository::class)]
class SummerMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?\DateTime $StartDate = null;

    #[ORM\ManyToOne(targetEntity: TeamSummerMatch::class, inversedBy: 'match')]
    private $teamSummerMatch = null;

    #[ORM\ManyToOne(inversedBy: 'team_id')]
    private ?Team $winner_id = null;

    public function __construct()
    {
        $this->teamSummerMatch = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->StartDate;
    }

    /**
     * @param \DateTime|null $StartDate
     */
    public function setStartDate(?\DateTime $StartDate): void
    {
        $this->StartDate = $StartDate;
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
        $previousWinner = $this->winner_id;
        $this->winner_id = $winner_id;
        if ($winner_id) {
            $winner_id->incrementPoints();
        }
        if ($previousWinner && $previousWinner !== $winner_id) {
            $previousWinner->decrementPoints();
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->id;

    }


}