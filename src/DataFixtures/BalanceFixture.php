<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Module\Balance\Entity\Balance;
use App\Module\User\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BalanceFixture extends BaseFixture implements DependentFixtureInterface
{

    public function loadData()
    {
        $this->createMany(Balance::class, 1, function(Balance $balance) {
            $balance
                ->setTotal(200)
                ->setUser($this->getReference(User::class . '|0'))
            ;
        });

        $this->manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}
