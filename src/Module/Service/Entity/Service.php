<?php

declare(strict_types=1);

namespace App\Module\Service\Entity;

use App\Helper\IdTrait;
use App\Module\Service\Repository\ServiceRepository;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
