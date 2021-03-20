<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etablissements;

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
        		$etablissements->setCoorX((float)$line[10]);
        		$etablissements->setCoorY((float)$line[11]);
        		$etablissements->setEpsg($line[12]);
        		$etablissements->setLatitude((float)$line[13]);
        		$etablissements->setLongitude((float)$line[14]);
        		$etablissements->setAppariement($line[15]);
        		$etablissements->setLocalisation($line[16]);
        		$etablissements->setNatureUai($line[17]);
        		$etablissements->setNatureUaiLibe($line[18]);
        		$etablissements->setEtatEtablissement($line[19]);
        		$etablissements->setEtatEtablissementLibe($line[20]);
        		$etablissements->setCodeDepartement((int)$line[21]);
        		$etablissements->setCodeRegion((int)$line[22]);
        		$etablissements->setCodeAcademie((int)$line[23]);
        		$etablissements->setCodeCommune((int)$line[24]);
        		$etablissements->setLibelleDepartement($line[25]);
        		$etablissements->setLibelleRegion($line[26]);
        		$etablissements->setLibelleAcademie($line[27]);
        		$etablissements->setPosition((float)$line[28]);
        		$etablissements->setSecteurPriveCodeTypeContrat((float)$line[29]);
        		$etablissements->setSecteurPriveLibelleTypeContrat((int)$line[30]);
        		$etablissements->setCodeMinistere($line[31]);
        		$etablissements->setLibelleMinistere($line[32]);
        		$etablissements->setDateOuverture((int)$line[33]);

        		$manager->persist($etablissements);
        		if($i % 10000 == 0) {
        			$manager->flush();
        		}
        	}
        	$i = $i + 1;
        }

        $manager->flush();
    }
}
