<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PartnerRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PartnerRepository::class)
 */
class Partner
{
    const PARTNER_STATUS_INACTIVE = 0;
    const PARTNER_STATUS_ACTIVE = 1;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected string $name = '';

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected string $url = '';

    /**
     * @ORM\Column(type="smallint", options={"default":1})
     */
    protected int $status = 1;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hotel", mappedBy="partner", cascade={"persist", "remove", "merge"})
     */
    protected Collection $hotels;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default":"CURRENT_TIMESTAMP"})
     */
    protected DateTime $created;

    public function __construct()
    {
        $this->status = self::PARTNER_STATUS_ACTIVE;
        $this->created = new DateTime();
        $this->hotels = new ArrayCollection();
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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
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
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Collection
     */
    public function getHotels(): Collection
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

    public function __toString()
    {
        return $this->name;
    }
}
