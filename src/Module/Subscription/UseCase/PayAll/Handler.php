<?php

declare(strict_types=1);

namespace App\Module\Subscription\UseCase\PayAll;

use App\Module\Subscription\Entity\Subscription;
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
        $user = $command->user;
        $subscriptions = $user->getSubscriptions();
        $balance = $user->getBalance();
        $totalSum = 0;

        foreach ($subscriptions as $subscription) {
            $totalSum += $subscription->getCount() * $subscription->getService()->getPrice();
        }

        if (count($subscriptions) < 1) {
            throw new \DomainException('У вас нет подписок!');
        } else if ($totalSum > $balance->getTotal()) {
            throw new \DomainException(
                sprintf(
                    'Недостаточно денег на вашем балансе. Для оплаты услуги, необходимо иметь на счету %d',
                    $totalSum
                )
            );
        }

        foreach ($subscriptions as $subscription) {
            $balanceSum = $this->newPay($subscription, $balance);
            $balance->setTotal($balanceSum);
        }

        $this->em->flush();
    }

    /**
     * @param $subscription
     * @param $balance
     * @return mixed
     */
    public function newPay(Subscription $subscription, $balance)
    {
        $sum = $subscription->getCount() * $subscription->getService()->getPrice();
        $newBalance = $balance->getTotal() - $sum;
        $transaction = (new Transaction())
            ->setService($subscription->getService())
            ->setBalance($balance)
            ->setAction(Transaction::ACTION_DECREASE)
            ->setSum($sum)
            ->setBalanceBefore($balance->getTotal())
            ->setBalanceAfter($newBalance)
        ;

        $this->em->persist($transaction);
        return $newBalance;
    }
}
