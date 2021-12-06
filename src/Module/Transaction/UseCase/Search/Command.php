<?php

declare(strict_types=1);

namespace App\Module\Transaction\UseCase\Search;

use App\Helper\CommandInterface;
use App\Module\Service\Entity\Service;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var Service|
     */
    public $service;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     */
    public $startDate;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     */
    public $endDate;
}
