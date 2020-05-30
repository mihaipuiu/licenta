<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RoomOccupationRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RoomOccupationRepository::class)
 */
class RoomOccupation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="roomOccupations", fetch="EAGER")
     */
    protected Room $room;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $bookDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="roomOccupations", fetch="EAGER")
     */
    protected User $user;

    public function __construct()
    {
        $this->bookDate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }

    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return DateTime
     */
    public function getBookDate(): DateTime
    {
        return $this->bookDate;
    }

    /**
     * @param DateTime $bookDate
     */
    public function setBookDate(DateTime $bookDate): void
    {
        $this->bookDate = $bookDate;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function hasRoomOccupationStarted(): bool
    {
        return $this->startDate < new \DateTime();
    }
}
