<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $NumeEchipa = null;

    #[ORM\Column]
    private ?int $NrOameni = null;

    //#[ORM\ManyToMany(targetEntity: SummerMatch::class, inversedBy: 'teams')]
    //private Collection $SummerMatch;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: TeamSummerMatch::class)]
    private Collection $teamSummerMatch;

    #[ORM\OneToMany(mappedBy: 'winner_id', targetEntity: SummerMatch::class)]
    private Collection $summerMatchesWon;

    public function __construct()
    {
        $this->teamSummerMatch = new ArrayCollection();
        $this->summerMatchesWon = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeEchipa(): ?string
    {
        return $this->NumeEchipa;
    }

    public function setNumeEchipa(string $NumeEchipa): static
    {
        $this->NumeEchipa = $NumeEchipa;

        return $this;
    }

    public function getNrOameni(): ?int
    {
        return $this->NrOameni;
    }

    public function setNrOameni(int $NrOameni): static
    {
        $this->NrOameni = $NrOameni;

        return $this;
    }


    /**
     * @return Collection<int, SummerMatch>
     */
    public function getSummerMatchesWon(): Collection
    {
        return $this->summerMatchesWon;
    }

    public function addSummerMatchesWon(SummerMatch $summerMatchesWon): static
    {
        if (!$this->summerMatchesWon->contains($summerMatchesWon)) {
            $this->summerMatchesWon->add($summerMatchesWon);
            $summerMatchesWon->setWinnerId($this);
        }

        return $this;
    }

    public function removeSummerMatchesWon(SummerMatch $summerMatchesWon): static
    {
        if ($this->summerMatchesWon->removeElement($summerMatchesWon)) {
            // set the owning side to null (unless already changed)
            if ($summerMatchesWon->getWinnerId() === $this) {
                $summerMatchesWon->setWinnerId(null);
            }
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTeamSummerMatch(): ArrayCollection
    {
        return $this->teamSummerMatch;
    }

    /**
     * @param ArrayCollection $teamSummerMatch
     */
    public function setTeamSummerMatch(ArrayCollection $teamSummerMatch): void
    {
        $this->teamSummerMatch = $teamSummerMatch;
    }

    public function __toString()
    {
        return $this->getNumeEchipa();
    }

}