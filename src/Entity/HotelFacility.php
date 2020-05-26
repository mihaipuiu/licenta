<?php

namespace App\Entity;

use App\Repository\HotelFacilityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HotelFacilityRepository::class)
 */
class HotelFacility
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private bool $hasRestaurant;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private bool $hasFitness;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private bool $hasWifi;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private bool $hasTv;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private bool $hasPool;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Hotel")
     */
    private Hotel $hotel;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function  getHasRestaurant(): bool
    {
        return $this->hasRestaurant;
    }

    /**
     * @param bool $hasRestaurant
     */
    public function setHasRestaurant(bool $hasRestaurant): void
    {
        $this->hasRestaurant = $hasRestaurant;
    }

    /**
     * @return bool
     */
    public function  getHasFitness(): bool
    {
        return $this->hasFitness;
    }

    /**
     * @param bool $hasFitness
     */
    public function setHasFitness(bool $hasFitness): void
    {
        $this->hasFitness = $hasFitness;
    }

    /**
     * @return bool
     */
    public function  getHasWifi(): bool
    {
        return $this->hasWifi;
    }

    /**
     * @param bool $hasWifi
     */
    public function setHasWifi(bool $hasWifi): void
    {
        $this->hasWifi = $hasWifi;
    }

    /**
     * @return bool
     */
    public function  getHasTv(): bool
    {
        return $this->hasTv;
    }

    /**
     * @param bool $hasTv
     */
    public function setHasTv(bool $hasTv): void
    {
        $this->hasTv = $hasTv;
    }

    /**
     * @return bool
     */
    public function  getHasPool(): bool
    {
        return $this->hasPool;
    }

    /**
     * @param bool $hasPool
     */
    public function setHasPool(bool $hasPool): void
    {
        $this->hasPool = $hasPool;
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
}
