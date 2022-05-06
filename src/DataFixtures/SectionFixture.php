<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SectionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=20;$i++){

            $s=new Section();
            $s->setDesignation("Designation$i");
            $manager->persist($s);
        }

        $manager->flush();
    }
}
