<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HotelPhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=HotelPhotoRepository::class)
 */
class HotelPhoto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="hotelPhotos")
     */
    protected ?Hotel $hotel = null;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected string $photoFilename = '';

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
    public function getPhotoFilename(): string
    {
        return $this->photoFilename;
    }

    /**
     * @param string $photoFilename
     */
    public function setPhotoFilename(string $photoFilename): void
    {
        $this->photoFilename = $photoFilename;
    }

    public function __toString()
    {
        return "$this->id";
    }
}
