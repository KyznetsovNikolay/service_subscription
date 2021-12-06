<?php

declare(strict_types=1);

namespace App\Module\Subscription\Entity;

use App\Helper\IdTrait;
use App\Module\Subscription\Repository\SubscriptionRepository;
use App\Module\User\Entity\User;
use App\Module\Service\Entity\Service;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 * @ORM\Table(name="subscriptions")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Subscription
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdTrait;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $count;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private $totalPrice;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="subscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="subscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    /**
     * @param $totalPrice
     * @return $this
     */
    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Service|null
     */
    public function getService(): ?Service
    {
        return $this->service;
    }

    /**
     * @param Service $service
     * @return $this
     */
    public function setService(Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
