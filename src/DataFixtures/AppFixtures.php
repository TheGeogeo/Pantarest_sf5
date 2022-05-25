<?php

namespace App\DataFixtures;

use App\Entity\Pin;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstName("Geogeo");
        $user->setLastName("Lamen");
        $user->setEmail("geogeo@example.com");
        $user->setPassword("$2y$13$0riMY0maGqmtgts9pyS7JOvAHEq3x0Q3qHsLS7xIMNHT8CXmNb2C6"); //geogeo
        $manager->persist($user);

        $pin = new Pin();
        $pin->setTitle("pin1");
        $pin->setDescription("la description pin 1");
        $pin->setUser($user);
        $manager->persist($pin);

        $manager->flush();
    }
}
