<?php

declare(strict_types=1);

namespace App\Service;

use App\Helper\CommandInterface;
use App\Module\Service\Entity\Service;
use App\Module\Subscription\UseCase\Add\Command;

class BalanceService
{
    /**
     * @var false|string
     */
    private $dayInMonth;

    /**
     * @var false|string
     */
    private $dayNow;

    public function __construct()
    {
        $this->dayInMonth = date('t', (new \DateTime())->getTimestamp());
        $this->dayNow = date('d', (new \DateTime())->getTimestamp());
    }

    /**
     * @param CommandInterface $command
     * @return bool
     */
    public function canPay(CommandInterface $command): bool
    {
        return $command->user->getBalance()->getTotal() > $this->getTotalSum($command);
    }

    /**
     * @param CommandInterface $command
     * @return float
     */
    public function getTotalSum(CommandInterface $command): float
    {
        /** @var Command $command */
        return $this->calculatePrice($command->service, $command->count);
    }

    /**
     * @return false|string
     */
    private function getCountDaysForPay()
    {
        return $this->dayInMonth - $this->dayNow;
    }

    /**
     * @param Service $service
     * @param $count
     * @return float
     */
    public function calculatePrice(Service $service, $count)
    {
        return round((($service->getPrice() / $this->dayInMonth) * $this->getCountDaysForPay()) * $count, 2);
    }
}
