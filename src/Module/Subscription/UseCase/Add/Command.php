<?php

declare(strict_types=1);

namespace App\Module\Subscription\UseCase\Add;

use App\Helper\CommandInterface;
use App\Module\Service\Entity\Service;
use App\Module\User\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var Service
     * @Assert\NotBlank()
     */
    public $service;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $count;

    /**
     * @var User
     * @Assert\NotBlank()
     */
    public $user;
}
