<?php

declare(strict_types=1);

namespace App\Module\Balance\Entity;

use App\Helper\CommandInterface;
use App\Helper\IdTrait;
use App\Module\Balance\Repository\BalanceRepository;
use App\Module\Transaction\UseCase\Search\Command;
use App\Module\User\Entity\User;
use App\Module\Transaction\Entity\Transaction;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
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

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="balance", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="balance")
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    /**
     * @return float|null
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return $this
     */
    public function setTotal(float $total): self
    {
        $this->total = $total;

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
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        // set the owning side of the relation if necessary
        if ($user->getBalance() !== $this) {
            $user->setBalance($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    /**
     * @param Transaction $transaction
     * @return $this
     */
    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setBalance($this);
        }

        return $this;
    }

    /**
     * @param Transaction $transaction
     * @return $this
     */
    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getBalance() === $this) {
                $transaction->setBalance(null);
            }
        }

        return $this;
    }

    public function getTransactionWithParams(CommandInterface $command)
    {
        /** @var Command  $command */
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->gte('createdAt', $command->startDate))
            ->andWhere(Criteria::expr()->lte('createdAt', $command->endDate))
        ;

        if ($command->service) {
            $criteria->andWhere(Criteria::expr()->eq('service', $command->service));
        }

        return $this->transactions->matching($criteria);
    }
}
