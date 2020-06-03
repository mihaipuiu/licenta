<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="rooms", fetch="EAGER")
     */
    protected ?Hotel $hotel = null;

    /**
     * @ORM\Column(type="string")
     */
    protected string $title = '';

    /**
     * @ORM\Column(type="string")
     */
    protected string $subtitle = '';

    /**
     * @ORM\Column(type="text")
     */
    protected string $description = '';

    /**
     * @ORM\Column(type="smallint")
     */
    protected int $maxGuests = 5;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $price = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RoomOccupation", mappedBy="room", fetch="EAGER")
     */
    protected Collection $roomOccupations;

    public function __construct()
    {
        $this->roomOccupations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Hotel
     */
    public function getHotel(): ?Hotel
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
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
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
     * @return int
     */
    public function getMaxGuests(): int
    {
        return $this->maxGuests;
    }

    /**
     * @param int $maxGuests
     */
    public function setMaxGuests(int $maxGuests): void
    {
        $this->maxGuests = $maxGuests;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Collection
     */
    public function getRoomOccupations(): Collection
    {
        return $this->roomOccupations;
    }

    /**
     * @param Collection $roomOccupations
     */
    public function setRoomOccupations(Collection $roomOccupations): void
    {
        $this->roomOccupations = $roomOccupations;
    }

    public function roomIsAvailable(\DateTime $checkInDate = null, \DateTime $checkOutDate = null): bool
    {
        $isAvailable = true;
        if($checkInDate && $checkOutDate) {
            /** @var RoomOccupation $occupation */
            foreach($this->roomOccupations as $occupation) {
                if($checkInDate >= $occupation->getStartDate()) {
                    if($checkInDate <= $occupation->getEndDate()) {
                        $isAvailable = false;
                    }
                }

                if($checkInDate < $occupation->getStartDate()) {
                    if($checkOutDate > $occupation->getStartDate()) {
                        $isAvailable = false;
                    }
                }
            }
        }

        return $isAvailable;
    }

    public function __toString()
    {
        return "$this->title";
    }
}
