<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", cascade={"all"}, fetch="EAGER")
     */
    protected Region $region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", cascade={"all"}, fetch="EAGER")
     */
    protected Country $country;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8)
     */
    protected float $latitude;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8)
     */
    protected float $longitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hotel", mappedBy="city", cascade={"persist", "remove", "merge"}, fetch="EAGER")
     */
    protected Collection $hotels;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;

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
     * @param Collection $hotels
     */
    public function setHotels(Collection $hotels): void
    {
        $this->hotels = $hotels;
    }
}
