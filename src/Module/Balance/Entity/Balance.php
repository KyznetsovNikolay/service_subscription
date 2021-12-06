<?php

declare(strict_types=1);

namespace App\Module\Balance\Entity;

use App\Helper\IdTrait;
use App\Module\Balance\Repository\BalanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BalanceRepository::class)
 * @ORM\Table(name="balances")
 */
class Balance
{
    use IdTrait;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $total;

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
