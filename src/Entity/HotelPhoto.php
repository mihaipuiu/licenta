<?php

namespace App\Entity;

use App\Repository\HotelPhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HotelPicturesRepository::class)
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
    protected Hotel $hotel;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected string $photoFilename;

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
}
