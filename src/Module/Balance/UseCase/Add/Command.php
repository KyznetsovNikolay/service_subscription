<?php

declare(strict_types=1);

namespace App\Module\Balance\UseCase\Add;

use App\Helper\CommandInterface;
use App\Module\User\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $sum;

    /**
     * @var User
     * @Assert\NotBlank()
     */
    public $user;
}
