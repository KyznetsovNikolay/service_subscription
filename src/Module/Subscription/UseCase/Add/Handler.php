<?php

declare(strict_types=1);

namespace App\Module\Subscription\UseCase\Add;

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
        $totalSum = $this->balanceService->getTotalSum($command);
        $balance = $command->user->getBalance();
        $balanceBefore = $balance->getTotal();
        $balanceAfter = $balanceBefore - $totalSum;
        $count = (int) $command->count;
        $subscriptionTotal = $command->service->getPrice() * $count;

        if (!$this->balanceService->canPay($command)) {
            throw new \DomainException(
                sprintf(
                    'Недостаточно средств. Вам нужно пополнить баланс. Необходимая сумма %s',
                    $totalSum
                )
            );
        }

        $subscription = (new Subscription())
            ->setUser($command->user)
            ->setCount((int) $command->count)
            ->setService($command->service)
            ->setTotalPrice($subscriptionTotal)
        ;

        $transaction = (new Transaction())
            ->setService($command->service)
            ->setBalance($command->user->getBalance())
            ->setAction(Transaction::ACTION_DECREASE)
            ->setSum($totalSum)
            ->setBalanceBefore($balanceBefore)
            ->setBalanceAfter($balanceAfter)
        ;

        $command->user->getBalance()->setTotal($balanceAfter);

        $this->em->persist($subscription);
        $this->em->persist($transaction);
        $this->em->flush();

        return $subscription;
    }
}
