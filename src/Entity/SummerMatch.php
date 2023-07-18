<?php

namespace App\Entity;

use App\Repository\SummerMatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TeamSummerMatch;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['StartDate'], message: 'Se joaca un meci in aceasta zi.')]
#[ORM\Entity(repositoryClass: SummerMatchRepository::class)]
class SummerMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\NotBlank(message: 'Alege o ora de start.')]
    #[ORM\Column(type: 'time')]
    private ?\DateTimeInterface $StartTime;

    #[Assert\NotBlank(message: 'Alege o data de start.')]
    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $StartDate;

    #[ORM\ManyToOne(targetEntity: TeamSummerMatch::class, inversedBy: 'summerMatches')]
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
     * @return \DateTimeInterface|null
     */
    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->StartTime;
    }

    /**
     * @param \DateTimeInterface|null $StartTime
     */
    public function setStartTime(?\DateTimeInterface $StartTime): void
    {
        $this->StartTime = $StartTime;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    /**
     * @param \DateTimeInterface|null $StartDate
     */
    public function setStartDate(?\DateTimeInterface $StartDate): void
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
            $winner_id->incrementMatchesWon();
        }
        if ($previousWinner && $previousWinner !== $winner_id) {
            $previousWinner->decrementPoints();
            $previousWinner->decrementMatchesWon();
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->id;

    }


}