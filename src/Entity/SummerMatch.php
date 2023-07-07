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

    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'SummerMatch')]
    private Collection $teams;

    #[ORM\ManyToOne(inversedBy: 'summerMatchesWon')]
    private ?Team $winner_id = null;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
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
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->addSummerMatch($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            $team->removeSummerMatch($this);
        }

        return $this;
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
