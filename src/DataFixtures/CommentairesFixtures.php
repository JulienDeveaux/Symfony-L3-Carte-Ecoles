<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Commentaires;


class CommentairesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i++) {
            $commentaire = new Commentaires();
            $commentaire->setNom("test");
            $adj = getdate();
            $date = new dateTime();
            $commentaire->setDateCreation($date);
            $commentaire->setNote(5);
            $commentaire->setTexte("testText");

            $manager->persist($commentaire);
            /*if($i % 1000) {
                $manager->flush();
            }*/
        }
        $manager->flush();
    }
}
