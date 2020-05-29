<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
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
    protected Hotel $hotel;

    /**
     * @ORM\Column(type="string")
     */
    protected string $title;

    /**
     * @ORM\Column(type="string")
     */
    protected string $subtitle;

    /**
     * @ORM\Column(type="text")
     */
    protected string $description;

    /**
     * @ORM\Column(type="smallint")
     */
    protected int $maxGuests;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RoomOccupation", mappedBy="room", fetch="EAGER")
     */
    protected PersistentCollection $roomOccupations;

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
     * @return PersistentCollection
     */
    public function getRoomOccupations(): PersistentCollection
    {
        return $this->roomOccupations;
    }

    /**
     * @param PersistentCollection $roomOccupations
     */
    public function setRoomOccupations(PersistentCollection $roomOccupations): void
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
}
