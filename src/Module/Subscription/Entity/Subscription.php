<?php

declare(strict_types=1);

namespace App\Module\Subscription\Entity;

use App\Helper\IdTrait;
use App\Module\Subscription\Repository\SubscriptionRepository;
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

    public function getCount(): ?int
    {
        return $this->count;
    }

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
}
