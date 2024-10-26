<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'coasters')]
class Coaster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $materialType;

    #[ORM\Column(type: 'string', length: 255)]
    private string $seatingType;

    #[ORM\Column(type: 'string', length: 255)]
    private string $model;

    #[ORM\Column(type: 'integer')]
    private int $speed;

    #[ORM\Column(type: 'integer')]
    private int $height;

    #[ORM\Column(type: 'integer')]
    private int $length;

    #[ORM\Column(type: 'integer')]
    private int $inversionsNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private string $manufacturer;

    #[ORM\Column(type: 'string', length: 255)]
    private string $restraint;

    #[ORM\Column(type: 'string', length: 255)]
    private array $launches;

    #[ORM\ManyToOne(targetEntity: Park::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Park $park;

    #[ORM\Column(type: 'string', length: 255)]
    private string $status;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $openingDate;

    #[ORM\Column(type: 'integer')]
    private int $totalRatings;

    #[ORM\Column(type: 'integer')]
    private int $validDuels;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 8)]
    private float $score;

    #[ORM\Column(type: 'integer')]
    private int $rank;

    #[ORM\Column(type: 'string', length: 255)]
    private string $mainImage;

    public function __construct(
        string $name,
        string $materialType,
        string $seatingType,
        string $model,
        int $speed,
        int $height,
        int $length,
        int $inversionsNumber,
        string $manufacturer,
        string $restraint,
        array $launches,
        Park $park,
        string $status,
        \DateTimeInterface $openingDate,
        int $totalRatings,
        int $validDuels,
        float $score,
        int $rank,
        string $mainImage
    )
    {
        $this->name = $name;
        $this->materialType = $materialType;
        $this->seatingType = $seatingType;
        $this->model = $model;
        $this->speed = $speed;
        $this->height = $height;
        $this->length = $length;
        $this->inversionsNumber = $inversionsNumber;
        $this->manufacturer = $manufacturer;
        $this->restraint = $restraint;
        $this->launches = $launches;
        $this->park = $park;
        $this->status = $status;
        $this->openingDate = $openingDate;
        $this->totalRatings = $totalRatings;
        $this->validDuels = $validDuels;
        $this->score = $score;
        $this->rank = $rank;
        $this->mainImage = $mainImage;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaterialType(): string
    {
        return $this->materialType;
    }

    public function getSeatingType(): string
    {
        return $this->seatingType;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getInversionsNumber(): int
    {
        return $this->inversionsNumber;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getRestraint(): string
    {
        return $this->restraint;
    }

    public function getLaunches(): array
    {
        return $this->launches;
    }

    public function getPark(): Park
    {
        return $this->park;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getOpeningDate(): \DateTimeInterface
    {
        return $this->openingDate;
    }

    public function getTotalRatings(): int
    {
        return $this->totalRatings;
    }

    public function getValidDuels(): int
    {
        return $this->validDuels;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getMainImage(): string
    {
        return $this->mainImage;
    }



}