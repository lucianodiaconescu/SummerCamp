<?php

namespace App\Entity;

use App\Repository\MembersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembersRepository::class)]
class Members
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $EchipaID = null;

    #[ORM\Column(length: 51)]
    private ?string $NumeJucator = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEchipaID(): ?Team
    {
        return $this->EchipaID;
    }

    public function setEchipaID(?Team $EchipaID): static
    {
        $this->EchipaID = $EchipaID;

        return $this;
    }

    public function getNumeJucator(): ?string
    {
        return $this->NumeJucator;
    }

    public function setNumeJucator(string $NumeJucator): static
    {
        $this->NumeJucator = $NumeJucator;

        return $this;
    }
}
