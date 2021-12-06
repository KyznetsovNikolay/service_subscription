<?php

declare(strict_types=1);

namespace App\Module\Transaction\Entity;

use App\Helper\IdTrait;
use App\Module\Transaction\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ORM\Table(name="transactions")
 */
class Transaction
{

    use TimestampableEntity;
    use IdTrait;

    const ACTION_REPLENISHMENT = 'replenishment';
    const ACTION_DECREASE = 'decrease';

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $action;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $sum;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $balanceBefore;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $balanceAfter;

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param $action
     * @return $this
     */
    public function setAction($action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param $sum
     * @return $this
     */
    public function setSum($sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBalanceBefore()
    {
        return $this->balanceBefore;
    }

    /**
     * @param $balanceBefore
     * @return $this
     */
    public function setBalanceBefore($balanceBefore): self
    {
        $this->balanceBefore = $balanceBefore;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBalanceAfter()
    {
        return $this->balanceAfter;
    }

    /**
     * @param $balanceAfter
     * @return $this
     */
    public function setBalanceAfter($balanceAfter): self
    {
        $this->balanceAfter = $balanceAfter;

        return $this;
    }

    public function getActionLabel(): string
    {
        $labels = [
            self::ACTION_DECREASE => 'Уменьшение',
            self::ACTION_REPLENISHMENT => 'Пополнение'
        ];

        return $labels[$this->action];
    }
}
