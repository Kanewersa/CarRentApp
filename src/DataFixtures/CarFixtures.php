<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $car = new Car();
        $car->setManufacturer("Smart")
            ->setModel("Fortwo")
            ->setFuelType("Diesel")
            ->setGearbox("Manualna")
            ->setSeats(2);

        $manager->persist($car);

        $car = new Car();
        $car->setManufacturer("Smart")
            ->setModel("Forfour")
            ->setFuelType("Elektryczne")
            ->setGearbox("Automatyczna")
            ->setSeats(4);

        $manager->persist($car);

        $manager->flush();
    }
}
