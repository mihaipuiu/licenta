<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
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
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $url;

    /**
     * @ORM\Column(type="smallint", options={"default":1})
     */
    private int $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hotel", mappedBy="partner", cascade={"persist", "remove", "merge"})
     */
    private PersistentCollection $hotels;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default":"CURRENT_TIMESTAMP"})
     */
    private DateTime $created;

    public function __construct()
    {
        $this->status = self::PARTNER_STATUS_ACTIVE;
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
     * @return PersistentCollection
     */
    public function getHotels(): PersistentCollection
    {
        return $this->hotels;
    }

    /**
     * @param PersistentCollection $hotels
     */
    public function setHotels(PersistentCollection $hotels): void
    {
        $this->hotels = $hotels;
    }
}
