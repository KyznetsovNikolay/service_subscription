<?php

declare(strict_types=1);

namespace App\Module\Service\Entity;

use App\Helper\IdTrait;
use App\Module\Service\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Module\Subscription\Entity\Subscription;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 * @ORM\Table(name="services")
 */
class Service
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="service", orphanRemoval=true)
     */
    private $subscriptions;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }
}
