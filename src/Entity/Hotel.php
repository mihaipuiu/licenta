<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HotelRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Hotel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected ?string $name = '';

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected ?string $address = '';

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected ?string $coordinates = '';

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected ?string $phone = '';

    /**
     * @ORM\Column(type="text")
     */
    protected ?string $shortDescription = '';

    /**
     * @ORM\Column(type="text")
     */
    protected ?string $fullDescription = '';

    /**
     * @ORM\Column(type="decimal", precision=2, scale=1, options={"default":"0.00"})
     */
    protected ?float $overallRating = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\HotelFacility", mappedBy="hotel", fetch="EAGER")
     */
    protected ?HotelFacility $hotelFacility = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="hotel", fetch="EAGER")
     */
    protected ?Collection $rooms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HotelReview", mappedBy="hotel", fetch="EAGER")
     */
    protected ?Collection $reviews;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", fetch="EAGER", inversedBy="hotels")
     */
    protected ?City $city = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partner", cascade={"all"}, inversedBy="hotels", fetch="EAGER")
     */
    protected ?Partner $partner = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HotelPhoto", mappedBy="hotel", fetch="EAGER")
     */
    protected ?Collection $hotelPhotos;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default":"CURRENT_TIMESTAMP"})
     */
    protected DateTime $created;

    public function __construct()
    {
        $this->created = new DateTime();
        $this->rooms = new ArrayCollection();
        $this->hotelPhotos = new ArrayCollection();
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
    public function getPartner(): ?Partner
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
    public function getCity(): ?City
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
    public function getHotelFacility(): ?HotelFacility
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
     * @return Collection<Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    /**
     * @param Collection $rooms
     */
    public function setRooms(Collection $rooms): void
    {
        $this->rooms = $rooms;
    }

    /**
     * @return Collection
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    /**
     * @param Collection $reviews
     */
    public function setReviews(Collection $reviews): void
    {
        $this->reviews = $reviews;
    }

    /**
     * @return Collection
     */
    public function getHotelPhotos(): Collection
    {
        return $this->hotelPhotos;
    }

    /**
     * @param Collection $hotelPhotos
     */
    public function setHotelPhotos(Collection $hotelPhotos): void
    {
        $this->hotelPhotos = $hotelPhotos;
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

    /**
     * @return float
     */
    public function getOverallRating(): ?float
    {
        return $this->overallRating;
    }

    public function getOverallRatingFromReviews(): float
    {
        $rating = 0.0;

        if(count($this->reviews) == 0.0) {
            return $rating;
        }

        /** @var HotelReview $review */
        foreach($this->reviews as $review) {
            $rating += $review->getOverallRating();
        }

        return round($rating/count($this->reviews), 1);
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

    public function getLastThreeReviews(): ArrayCollection
    {
        return new ArrayCollection([
            $this->reviews->get(count($this->reviews)-1),
            $this->reviews->get(count($this->reviews)-2),
            $this->reviews->get(count($this->reviews)-3)
        ]);
    }

    public function getLowestPriceRoom(): Room
    {
        $minPriceRoom = new Room();
        $minPriceRoom->setPrice(90000000);
        /** @var Room $room */
        foreach($this->rooms as $room) {
            if($minPriceRoom->getPrice() > $room->getPrice()) {
                $minPriceRoom = $room;
            }
        }

        return $minPriceRoom;
    }

    public function getHighestPriceRoom(): Room
    {
        $minPriceRoom = new Room();
        $minPriceRoom->setPrice(90000000);
        /** @var Room $room */
        foreach($this->rooms as $room) {
            if($minPriceRoom->getPrice() > $room->getPrice()) {
                $minPriceRoom = $room;
            }
        }

        return $minPriceRoom;
    }

    public function hasAnyRoomAvailable(\DateTime $checkInDate = null, \DateTime $checkOutDate = null): bool
    {
        /** @var Room $room */
        foreach($this->getRooms() as $room) {
            if($room->roomIsAvailable($checkInDate, $checkOutDate)) {
                return true;
            }
        }
        return false;
    }

    public static function getLowestPriceRoomOfHotels($hotels): Room
    {
        $minPriceRoom = new Room();
        $minPriceRoom->setPrice(90000000);
        /** @var Hotel $hotel */
        foreach($hotels as $hotel) {
            /** @var Room $room */
            foreach($hotel->rooms as $room) {
                if($minPriceRoom->getPrice() > $room->getPrice()) {
                    $minPriceRoom = $room;
                }
            }
        }

        return $minPriceRoom;
    }

    public static function getHighestPriceRoomOfHotels($hotels): Room
    {
        $maxPriceRoom = new Room();
        $maxPriceRoom->setPrice(0);
        /** @var Hotel $hotel */
        foreach($hotels as $hotel) {
            /** @var Room $room */
            foreach($hotel->rooms as $room) {
                if($maxPriceRoom->getPrice() < $room->getPrice()) {
                    $maxPriceRoom = $room;
                }
            }
        }

        return $maxPriceRoom;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        $this->overallRating = $this->getOverallRatingFromReviews();
    }

    /**
     * @param DateTime|string|null $checkInDate
     * @param DateTime|string|null $checkOutDate
     * @param int $minGuests
     * @return array
     */
    public function getAvailableRooms($checkInDate = null, $checkOutDate = null, int $minGuests = 1): array
    {
        $availableRooms = [];

        if (is_string($checkInDate)) {
            $checkInDate = \DateTime::createFromFormat('m/d/Y', $checkInDate) ?: null;

        }

        if (is_string($checkOutDate)) {
            $checkOutDate = \DateTime::createFromFormat('m/d/Y', $checkOutDate)  ?: null;
        }

        /** @var Room $room */
        foreach($this->getRooms() as $room) {
            if($room->getMaxGuests() >= $minGuests && $room->roomIsAvailable($checkInDate, $checkOutDate)) {
                $availableRooms[] = $room;
            }
        }

        return $availableRooms;
    }

    public function __toString()
    {
        return "$this->name";
    }
}
