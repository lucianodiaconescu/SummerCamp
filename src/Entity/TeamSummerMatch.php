<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "team_summer_match")]
class TeamSummerMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teamSummerMatch')]
    private ?Team $team= null;


    #[ORM\ManyToOne(targetEntity: SummerMatch::class, inversedBy: 'teamSummerMatch')]
    private $match= null;



    /**
     * @var integer
     * @ORM\Column(name="nr_puncte", type="integer")
     */
    protected $nr_puncte;

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
}