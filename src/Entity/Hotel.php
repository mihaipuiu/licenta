<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

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
    private PersistentCollection $rooms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HotelReview", mappedBy="hotel")
     */
    private PersistentCollection $reviews;

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
        $this->created = new DateTime();
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
     * @return PersistentCollection<Room>
     */
    public function getRooms(): PersistentCollection
    {
        return $this->rooms;
    }

    /**
     * @param PersistentCollection $rooms
     */
    public function setRooms(PersistentCollection $rooms): void
    {
        $this->rooms = $rooms;
    }

    /**
     * @return PersistentCollection
     */
    public function getReviews(): PersistentCollection
    {
        return $this->reviews;
    }

    /**
     * @param PersistentCollection $reviews
     */
    public function setReviews(PersistentCollection $reviews): void
    {
        $this->reviews = $reviews;
    }

    public function getAveragePrice(): int
    {
        $sum = 0;
        if(count($this->rooms) == 0) {
            return $sum;
        }

        /** @var Room $room */
        foreach($this->rooms as $room) {
            $sum += $room->getPrice();
        }

        return $sum/count($this->rooms);
    }

    public function getOverallRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getOverallRating();
        }

        return $rating/count($this->reviews);
    }

    public function getOverallServiceRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getServiceRating();
        }

        return $rating/count($this->reviews);
    }

    public function getOverallSleepRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getSleepRating();
        }

        return $rating/count($this->reviews);
    }

    public function getOverallLocationRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getLocationRating();
        }

        return $rating/count($this->reviews);
    }

    public function getOverallPoolRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getPoolRating();
        }

        return $rating/count($this->reviews);
    }

    public function getOverallValueRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getValueRating();
        }

        return $rating/count($this->reviews);
    }

    public function getOverallCleanlinessRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getCleanlinessRating();
        }

        return $rating/count($this->reviews);
    }

    public function getOverallRoomsRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getRoomsRating();
        }

        return $rating/count($this->reviews);
    }

    public function getOverallFitnessRating(): int
    {
        $rating = 0;

        if(count($this->reviews) == 0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getFitnessRating();
        }

        return $rating/count($this->reviews);
    }
}
