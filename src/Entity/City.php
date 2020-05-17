<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", cascade={"all"})
     */
    private Region $region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", cascade={"all"})
     */
    private Country $country;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8)
     */
    private float $latitude;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8)
     */
    private float $longitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hotel", mappedBy="city", cascade={"persist", "remove", "merge"})
     */
    private ArrayCollection $hotels;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Region
     */
    public function getRegion(): Region
    {
        return $this->region;
    }

    /**
     * @param Region $region
     */
    public function setRegion(Region $region): void
    {
        $this->region = $region;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
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
     * @return ArrayCollection
     */
    public function getHotels(): ArrayCollection
    {
        return $this->hotels;
    }

    /**
     * @param ArrayCollection $hotels
     */
    public function setHotels(ArrayCollection $hotels): void
    {
        $this->hotels = $hotels;
    }
}
