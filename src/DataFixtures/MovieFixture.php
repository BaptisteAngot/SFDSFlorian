<?php


namespace App\DataFixtures;


use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class MovieFixture extends Fixture
{


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 40; $i++)
        {
            $faker = Faker\Factory::create('FR-fr');
            $movie = new Video();
            $movie->setName($faker->name);
            $movie->setDate(new \DateTime());
            $movie->setSynopsis($faker->text);
            $movie->setType("movie");
            $manager->persist($movie);
        }
        $manager->flush();
    }
}