<?php

declare(strict_types=1);

namespace App\Module\Subscription\UseCase\PayAll;

use App\Helper\CommandInterface;
use App\Module\User\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var User
     * @Assert\NotBlank()
     */
    public $user;
}
