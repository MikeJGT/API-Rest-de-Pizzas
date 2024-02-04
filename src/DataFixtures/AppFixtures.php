<?php

namespace App\DataFixtures;

use App\Story\PizzaStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PizzaStory::load();
        $manager->flush();
    }
}
