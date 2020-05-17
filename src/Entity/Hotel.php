<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 */
class Hotel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private string $address;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $coordinates;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $phone;

    /**
     * @ORM\Column(type="text")
     */
    private string $shortDescription;

    /**
     * @ORM\Column(type="text")
     */
    private string $fullDescription;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\HotelFacility", mappedBy="hotel")
     */
    private HotelFacility $hotelFacility;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="hotel")
     */
    private ArrayCollection $rooms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HotelReview", mappedBy="hotel")
     */
    private ArrayCollection $reviews;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     */
    private City $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partner", cascade={"all"}, inversedBy="hotels")
     */
    private Partner $partner;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default":"CURRENT_TIMESTAMP"})
     */
    private DateTime $created;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCoordinates(): string
    {
        return $this->coordinates;
    }

    /**
     * @param string $coordinates
     */
    public function setCoordinates(string $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }



    /**
     * @return Partner
     */
    public function getPartner(): Partner
    {
        return $this->partner;
    }

    /**
     * @param Partner $partner
     */
    public function setPartner(Partner $partner): void
    {
        $this->partner = $partner;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city): void
    {
        $this->city = $city;
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

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getFullDescription(): string
    {
        return $this->fullDescription;
    }

    /**
     * @param string $fullDescription
     */
    public function setFullDescription(string $fullDescription): void
    {
        $this->fullDescription = $fullDescription;
    }

    /**
     * @return HotelFacility
     */
    public function getHotelFacility(): HotelFacility
    {
        return $this->hotelFacility;
    }

    /**
     * @param HotelFacility $hotelFacility
     */
    public function setHotelFacility(HotelFacility $hotelFacility): void
    {
        $this->hotelFacility = $hotelFacility;
    }

    /**
     * @return ArrayCollection
     */
    public function getRooms(): ArrayCollection
    {
        return $this->rooms;
    }

    /**
     * @param ArrayCollection $rooms
     */
    public function setRooms(ArrayCollection $rooms): void
    {
        $this->rooms = $rooms;
    }

    /**
     * @return ArrayCollection
     */
    public function getReviews(): ArrayCollection
    {
        return $this->reviews;
    }

    /**
     * @param ArrayCollection $reviews
     */
    public function setReviews(ArrayCollection $reviews): void
    {
        $this->reviews = $reviews;
    }
}
