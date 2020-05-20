<?php

namespace App\Entity;

use App\Repository\HotelReviewRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HotelReviewRepository::class)
 */
class HotelReview
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="reviews")
     */
    private Hotel $hotel;

    /**
     * @ORM\Column(type="decimal", precision=2, scale=1)
     */
    private float $overallRating;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $serviceRating;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $sleepRating;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $locationRating;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $poolRating;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $valueRating;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $cleanlinessRating;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $roomsRating;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $fitnessRating;

    /**
     * @ORM\Column(type="text")
     */
    private string $title;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="string")
     */
    private string $reviewerName;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default":"CURRENT_TIMESTAMP"})
     */
    private DateTime $created;

    public function __construct()
    {
        $this->created = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Hotel
     */
    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    /**
     * @param Hotel $hotel
     */
    public function setHotel(Hotel $hotel): void
    {
        $this->hotel = $hotel;
    }

    /**
     * @return float
     */
    public function getOverallRating(): float
    {
        return $this->overallRating;
    }

    /**
     * @param float $overallRating
     */
    public function setOverallRating(float $overallRating): void
    {
        $this->overallRating = $overallRating;
    }

    /**
     * @return int
     */
    public function getServiceRating(): int
    {
        return $this->serviceRating;
    }

    /**
     * @param int $serviceRating
     */
    public function setServiceRating(int $serviceRating): void
    {
        $this->serviceRating = $serviceRating;
    }

    /**
     * @return int
     */
    public function getSleepRating(): int
    {
        return $this->sleepRating;
    }

    /**
     * @param int $sleepRating
     */
    public function setSleepRating(int $sleepRating): void
    {
        $this->sleepRating = $sleepRating;
    }

    /**
     * @return int
     */
    public function getLocationRating(): int
    {
        return $this->locationRating;
    }

    /**
     * @param int $locationRating
     */
    public function setLocationRating(int $locationRating): void
    {
        $this->locationRating = $locationRating;
    }

    /**
     * @return int
     */
    public function getPoolRating(): int
    {
        return $this->poolRating;
    }

    /**
     * @param int $poolRating
     */
    public function setPoolRating(int $poolRating): void
    {
        $this->poolRating = $poolRating;
    }

    /**
     * @return int
     */
    public function getValueRating(): int
    {
        return $this->valueRating;
    }

    /**
     * @param int $valueRating
     */
    public function setValueRating(int $valueRating): void
    {
        $this->valueRating = $valueRating;
    }

    /**
     * @return int
     */
    public function getCleanlinessRating(): int
    {
        return $this->cleanlinessRating;
    }

    /**
     * @param int $cleanlinessRating
     */
    public function setCleanlinessRating(int $cleanlinessRating): void
    {
        $this->cleanlinessRating = $cleanlinessRating;
    }

    /**
     * @return int
     */
    public function getRoomsRating(): int
    {
        return $this->roomsRating;
    }

    /**
     * @param int $roomsRating
     */
    public function setRoomsRating(int $roomsRating): void
    {
        $this->roomsRating = $roomsRating;
    }

    /**
     * @return int
     */
    public function getFitnessRating(): int
    {
        return $this->fitnessRating;
    }

    /**
     * @param int $fitnessRating
     */
    public function setFitnessRating(int $fitnessRating): void
    {
        $this->fitnessRating = $fitnessRating;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getReviewerName(): string
    {
        return $this->reviewerName;
    }

    /**
     * @param string $reviewerName
     */
    public function setReviewerName(string $reviewerName): void
    {
        $this->reviewerName = $reviewerName;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }
}
