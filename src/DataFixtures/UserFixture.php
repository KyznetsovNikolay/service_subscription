<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Module\User\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData()
    {
        $this->createMany(User::class, 1, function(User $user) {
            $user
                ->setName('John')
                ->setSurname('Doe')
            ;
        });

        $this->manager->flush();
    }

    public function getDependencies()
    {
        return [
            ServiceFixture::class,
        ];
    }
}
