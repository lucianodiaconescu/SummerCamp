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

    #[ORM\ManyToMany(targetEntity: SummerMatch::class, inversedBy: 'teams')]
    private Collection $SummerMatch;

    #[ORM\OneToMany(mappedBy: 'winner_id', targetEntity: SummerMatch::class)]
    private Collection $summerMatchesWon;

    #[ORM\OneToOne(mappedBy: 'EchipaID', cascade: ['persist', 'remove'])]
    private ?TeamMembers $teamMembers = null;

    #[ORM\OneToMany(mappedBy: 'NumeJucator', targetEntity: TeamMembers::class, orphanRemoval: true)]
    private Collection $teamMembersNames;

    public function __construct()
    {
        $this->SummerMatch = new ArrayCollection();
        $this->summerMatchesWon = new ArrayCollection();
        $this->Members = [];
        $this->teamMembersNames = new ArrayCollection();
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
    public function getSummerMatch(): Collection
    {
        return $this->SummerMatch;
    }

    public function addSummerMatch(SummerMatch $summerMatch): static
    {
        if (!$this->SummerMatch->contains($summerMatch)) {
            $this->SummerMatch->add($summerMatch);
        }

        return $this;
    }

    public function removeSummerMatch(SummerMatch $summerMatch): static
    {
        $this->SummerMatch->removeElement($summerMatch);

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

    public function __toString()
    {
        return $this->getNumeEchipa();
    }

    public function getTeamMembers(): ?TeamMembers
    {
        return $this->teamMembers;
    }

    public function setTeamMembers(TeamMembers $teamMembers): static
    {
        // set the owning side of the relation if necessary
        if ($teamMembers->getEchipaID() !== $this) {
            $teamMembers->setEchipaID($this);
        }

        $this->teamMembers = $teamMembers;

        return $this;
    }

    /**
     * @return Collection<int, TeamMembers>
     */
    public function getTeamMembersNames(): Collection
    {
        return $this->teamMembersNames;
    }

    public function addTeamMembersName(TeamMembers $teamMembersName): static
    {
        if (!$this->teamMembersNames->contains($teamMembersName)) {
            $this->teamMembersNames->add($teamMembersName);
            $teamMembersName->setNumeJucator($this);
        }

        return $this;
    }

    public function removeTeamMembersName(TeamMembers $teamMembersName): static
    {
        if ($this->teamMembersNames->removeElement($teamMembersName)) {
            // set the owning side to null (unless already changed)
            if ($teamMembersName->getNumeJucator() === $this) {
                $teamMembersName->setNumeJucator(null);
            }
        }

        return $this;
    }
}
