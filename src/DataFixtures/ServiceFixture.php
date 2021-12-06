<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Module\Service\Entity\Service;

class ServiceFixture extends BaseFixture
{
    public function loadData()
    {
        foreach ($this->getdata() as $element) {
            $this->create(Service::class, function(Service $service) use ($element) {
                $service
                    ->setName($element['name'])
                    ->setPrice((float) $element['price'])
                ;
            });
        }

        $this->manager->flush();
    }

    private function getdata()
    {
        return [
            [
                'name' => 'Лифт',
                'price' => '50'
            ],
            [
                'name' => 'Вывоз мусора',
                'price' => '45'
            ],
            [
                'name' => 'Электричество',
                'price' => '70'
            ],
            [
                'name' => 'Ремонт в подъезде',
                'price' => '25'
            ],
        ];
    }
}
