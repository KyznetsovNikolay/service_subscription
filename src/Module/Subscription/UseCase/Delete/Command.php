<?php

declare(strict_types=1);

namespace App\Module\Subscription\UseCase\Delete;

use App\Helper\CommandInterface;
use App\Module\Subscription\Entity\Subscription;
use App\Module\User\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var Subscription
     * @Assert\NotBlank()
     */
    public $subscription;

    /**
     * @var User
     * @Assert\NotBlank()
     */
    public $user;

    public function __construct(Subscription $subscription, User $user)
    {
        $this->subscription = $subscription;
        $this->user = $user;
    }
}
