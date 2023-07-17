<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[Orm\Entity(repositoryClass: "App\Repository\TeamSummerMatchRepository")]
#[ORM\Table(name: "team_summer_match")]
class TeamSummerMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teamSummerMatch')]
    private ?Team $team = null;

    #[ORM\ManyToOne(targetEntity: SummerMatch::class, inversedBy: 'teamSummerMatch')]
    private $match = null;

    /**
     * @var integer
     * @ORM\Column(name="nr_puncte", type="integer")
     */
    protected $nr_puncte;

    #[ORM\OneToMany(mappedBy: 'winnerid', targetEntity: SummerMatch::class)]
    private Collection $summerMatches;

    public function __construct()
    {
        $this->summerMatches = new ArrayCollection();
    }

    /**
     * @return int
     */

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team): void
    {
        $this->team = $team;
    }

    /**
     * @return mixed
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @param mixed $match
     */
    public function setMatch($match): void
    {
        $this->match = $match;
    }

    /**
     * @return int
     */
    public function getNrPuncte(): int
    {
        return $this->nr_puncte;
    }

    /**
     * @param int $nr_puncte
     */
    public function setNrPuncte(int $nr_puncte): void
    {
        $this->nr_puncte = $nr_puncte;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }

    /**
     * @return Collection<int, SummerMatch>
     */
    public function getSummerMatches(): Collection
    {
        return $this->summerMatches;
    }

    public function addSummerMatch(SummerMatch $summerMatch): self
    {
        if (!$this->summerMatches->contains($summerMatch)) {
            $this->summerMatches->add($summerMatch);
            $summerMatch->setMatch($this);
        }

        return $this;
    }

    public function removeSummerMatch(SummerMatch $summerMatch): self
    {
        if ($this->summerMatches->removeElement($summerMatch)) {
            // set the owning side to null (unless already changed)
            if ($summerMatch->getMatch() === $this) {
                $summerMatch->setMatch(null);
            }
        }

        return $this;
    }
}