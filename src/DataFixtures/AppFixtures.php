<?php

namespace App\DataFixtures;

use App\Entity\Pin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $pin = new Pin();
            $pin->setTitle("Title $i");
            $pin->setDescription("Description $i");
            $manager->persist($pin);
        }

        $manager->flush();
    }
}
