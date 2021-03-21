<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etablissements;
use App\Entity\Commentaires;

class EtablissementsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csv = fopen('./data/fr-en-adresse-et-geolocalisation-etablissements-premier-et-second-degre.csv', 'r');

        $i = 0;
        while(!feof($csv)) {
        	$line = fgetcsv($csv, 0, ';');
        	if($i > 0) {
        		$etablissements = new Etablissements();
        		$etablissements->setAppelationOfficielle((string)$line[1]);
        		$etablissements->setDenominationPrincipale($line[2]);
        		$etablissements->setPatronyme($line[3]);
        		$etablissements->setSecteurPublicPrive($line[4]);
        		$etablissements->setAddresse($line[5]);
        		$etablissements->setLieuDit($line[6]);
        		$etablissements->setBoitePostale((int)$line[7]);
        		$etablissements->setCodePostal($line[8]);
        		$etablissements->setLocalite($line[9]);
        		$etablissements->setLibelleCommune($line[10]);
        		$etablissements->setCoorX((float)$line[11]);
        		$etablissements->setCoorY((float)$line[12]);
        		$etablissements->setEpsg($line[13]);
        		$etablissements->setLatitude((float)$line[14]);
        		$etablissements->setLongitude((float)$line[15]);
        		$etablissements->setAppariement($line[16]);
        		$etablissements->setLocalisation($line[17]);
        		$etablissements->setNatureUai($line[18]);
        		$etablissements->setNatureUaiLibe($line[19]);
        		$etablissements->setEtatEtablissement($line[20]);
        		$etablissements->setEtatEtablissementLibe($line[21]);
        		$etablissements->setCodeDepartement((int)$line[22]);
        		$etablissements->setCodeRegion((int)$line[23]);
        		$etablissements->setCodeAcademie((int)$line[24]);
        		$etablissements->setCodeCommune((int)$line[25]);
        		$etablissements->setLibelleDepartement($line[26]);
        		$etablissements->setLibelleRegion($line[27]);
        		$etablissements->setLibelleAcademie($line[28]);
        		$etablissements->setPosition((float)$line[29]);
        		$etablissements->setSecteurPriveCodeTypeContrat((float)$line[30]);
        		$etablissements->setSecteurPriveLibelleTypeContrat((int)$line[31]);
        		$etablissements->setCodeMinistere($line[32]);
        		$etablissements->setLibelleMinistere($line[33]);
        		$etablissements->setDateOuverture((int)$line[34]);

                $commentaire = new Commentaires();
                $commentaire->setNom("Ceci est un nom automatique " . $i);
                $adj = getdate();
                $date = new dateTime();
                $commentaire->setDateCreation($date);
                $commentaire->setNote(3);
                $commentaire->setTexte("Ceci est un commentaire automatique " . $i);
                $manager->persist($commentaire);
                $etablissements->addCommentaire($commentaire);

        		$manager->persist($etablissements);
        		if($i % 30000 == 0) {
        			$manager->flush();
        			break;
        		}
        	}
        	$i = $i + 1;
        }

        $manager->flush();
    }
}
