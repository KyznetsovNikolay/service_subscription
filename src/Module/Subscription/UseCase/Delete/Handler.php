<?php

declare(strict_types=1);

namespace App\Module\Subscription\UseCase\Delete;

use App\Module\Subscription\Entity\Subscription;
use App\Module\Transaction\Entity\Transaction;
use App\Service\BalanceService;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var BalanceService
     */
    private $balanceService;

    public function __construct(EntityManagerInterface $em, BalanceService $balanceService)
    {
        $this->em = $em;
        $this->balanceService = $balanceService;
    }

    /**
     * @param Command $command
     * @return Subscription
     */
    public function handle(Command $command): Subscription
    {
        $subscription = $command->subscription;
        $balance = $command->user->getBalance();
        $balanceBefore = $balance->getTotal();

        $subscription->setDeletedAt(new \DateTime());
        $sum = $this->balanceService->calculatePrice($subscription->getService(), $subscription->getCount());
        $balanceAfter = $balance->getTotal() + $sum;
        $balance->setTotal($balanceAfter);

        $transaction = (new Transaction())
            ->setBalance($balance)
            ->setBalanceBefore($balanceBefore)
            ->setBalanceAfter($balanceAfter)
            ->setSum($sum)
            ->setService($subscription->getService())
            ->setAction(Transaction::ACTION_REPLENISHMENT)
        ;

        $this->em->persist($transaction);
        $this->em->flush();

        return $subscription;
    }
}
