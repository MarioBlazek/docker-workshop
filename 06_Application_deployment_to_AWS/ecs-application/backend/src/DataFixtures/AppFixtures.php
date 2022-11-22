<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Xylis\FakerCinema\Provider\Movie as MovieProvider;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new MovieProvider($faker));

        for ($i = 0; $i < 20; $i++) {
            $movie = new Movie(
                $faker->numberBetween(100000, 1000000),
                sprintf("%s - %s", $faker->movie, $faker->runtime)
            );
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
