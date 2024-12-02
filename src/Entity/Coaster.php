<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
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
    private string $idCoaster;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: MaterialType::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private MaterialType $materialType;

    #[ORM\ManyToOne(targetEntity: SeatingType::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private SeatingType $seatingType;

    #[ORM\ManyToOne(targetEntity: Model::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Model $model;

    #[ORM\Column(type: 'integer')]
    private int $speed;

    #[ORM\Column(type: 'integer')]
    private int $height;

    #[ORM\Column(type: 'integer')]
    private int $length;

    #[ORM\Column(type: 'integer')]
    private int $inversionsNumber;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Manufacturer $manufacturer;

    #[ORM\ManyToOne(targetEntity: Restraint::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Restraint $restraint;

    #[ORM\ManyToMany(targetEntity: Launches::class, cascade: ['persist'])]
    private Collection $launches;


    #[ORM\ManyToOne(targetEntity: Park::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Park $park;

    #[ORM\ManyToOne(targetEntity: Status::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Status $status;
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
        string $idCoaster,
        string $name,
        MaterialType $materialType,
        SeatingType $seatingType,
        Model $model,
        int $speed,
        int $height,
        int $length,
        int $inversionsNumber,
        Manufacturer $manufacturer,
        Restraint $restraint,
        Collection $launches,
        Park $park,
        Status $status,
        \DateTimeInterface $openingDate,
        int $totalRatings,
        int $validDuels,
        float $score,
        int $rank,
        string $mainImage
    )
    {
        $this->idCoaster = $idCoaster;
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

    public function getIdCoaster(): string
    {
        return $this->idCoaster;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaterialType(): MaterialType
    {
        return $this->materialType;
    }

    public function getSeatingType(): SeatingType
    {
        return $this->seatingType;
    }

    public function getModel(): Model
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

    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    public function getRestraint(): Restraint
    {
        return $this->restraint;
    }

    public function getLaunches(): Collection
    {
        return $this->launches;
    }

    public function getPark(): Park
    {
        return $this->park;
    }

    public function getStatus(): Status
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'idCoaster' => $this->idCoaster,
            'name' => $this->name,
            'materialType' => $this->materialType->getName(),
            'seatingType' => $this->seatingType->getName(),
            'model' => $this->model->getName(),
            'speed' => $this->speed,
            'height' => $this->height,
            'length' => $this->length,
            'inversionsNumber' => $this->inversionsNumber,
            'manufacturer' => $this->manufacturer->getName(),
            'restraint' => $this->restraint->getName(),
            'launches' => array_map(fn($launch) => $launch->getName(), $this->launches->toArray()),
            'park' => $this->park->getName(),
            'status' => $this->status->getName(),
            'openingDate' => $this->openingDate->format('Y-m-d'),
            'totalRatings' => $this->totalRatings,
            'validDuels' => $this->validDuels,
            'score' => $this->score,
            'rank' => $this->rank,
            'mainImage' => $this->mainImage,
        ];
    }


}