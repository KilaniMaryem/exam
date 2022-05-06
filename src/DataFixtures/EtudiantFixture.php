<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtudiantFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr');
        for($i=1;$i<=20;$i++){
            $e=new Etudiant();
            $e->setNom($faker->name);
            $e->setPrenom($faker->firstName);
            $s=new Section();
            $s->setDesignation("Designation");
            $manager->persist($s);
            $manager->flush();
            $e->setSection($s);
            $manager->persist($e);
        }
        for($i=21;$i<=40;$i++){
            $e=new Etudiant();
            $e->setNom($faker->name);
            $e->setPrenom($faker->firstName);

            $manager->persist($e);
        }

        $manager->flush();
    }
}
