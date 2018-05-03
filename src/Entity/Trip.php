<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Trip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    /**
     * @ORM\Column(type="datetimetz_immutable")
     */
    private $start;

    /**
     * @ORM\Column(type="datetimetz_immutable")
     */
    private $end;

    /**
     * @ORM\Column(type="integer")
     */
    private $expenses;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setStart(\DateTimeImmutable $start): void
    {
        $this->start = $start;
    }

    public function setEnd(\DateTimeImmutable $end): void
    {
        $this->end = $end;
    }

    public function getExpenses(): int
    {
        return $this->expenses;
    }

    public function setExpenses(int $expenses): void
    {
        $this->expenses = $expenses;
    }
}