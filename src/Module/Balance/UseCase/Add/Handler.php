<?php

declare(strict_types=1);

namespace App\Module\Balance\UseCase\Add;

use App\Module\Transaction\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(Command $command)
    {
        $balance = $command->user->getBalance();
        $beforeBalance = $balance->getTotal();
        $afterBalance = $beforeBalance + (float) $command->sum;
        $balance->setTotal($afterBalance);

        $transaction = (new Transaction())
            ->setBalance($command->user->getBalance())
            ->setAction(Transaction::ACTION_REPLENISHMENT)
            ->setSum($command->sum)
            ->setBalanceBefore($beforeBalance)
            ->setBalanceAfter($afterBalance)
        ;

        $this->em->persist($transaction);
        $this->em->flush();
    }
}
