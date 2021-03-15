<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315093621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE etablissements_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE etablissements (id INT NOT NULL, appelation_officielle VARCHAR(255) NOT NULL, denomination_principale VARCHAR(255) NOT NULL, patronyme VARCHAR(255) NOT NULL, secteur_public_prive VARCHAR(255) NOT NULL, addresse VARCHAR(255) NOT NULL, lieu_dit VARCHAR(255) DEFAULT NULL, boite_postale INT DEFAULT NULL, code_postal INT NOT NULL, localite VARCHAR(255) NOT NULL, coor_x DOUBLE PRECISION NOT NULL, coor_y DOUBLE PRECISION NOT NULL, epsg VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, appariement VARCHAR(255) NOT NULL, localisation VARCHAR(255) DEFAULT NULL, nature_uai VARCHAR(255) DEFAULT NULL, nature_uai_libe VARCHAR(255) DEFAULT NULL, etat_etablissement VARCHAR(255) DEFAULT NULL, etat_etablissement_libe VARCHAR(255) DEFAULT NULL, code_departement INT NOT NULL, code_region INT NOT NULL, code_academie INT NOT NULL, code_commune INT NOT NULL, libelle_departement VARCHAR(255) DEFAULT NULL, libelle_region VARCHAR(255) DEFAULT NULL, libelle_academie VARCHAR(255) DEFAULT NULL, position DOUBLE PRECISION NOT NULL, secteur_prive_code_type_contrat DOUBLE PRECISION NOT NULL, secteur_prive_libelle_type_contrat INT DEFAULT NULL, code_ministere VARCHAR(255) DEFAULT NULL, libelle_ministere INT DEFAULT NULL, date_ouverture INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE test (id INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etablissements_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_id_seq CASCADE');
        $this->addSql('DROP TABLE etablissements');
        $this->addSql('DROP TABLE test');
    }
}
