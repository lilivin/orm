<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327095352 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE komunikacja (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE miasta (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mieszkania (id INT AUTO_INCREMENT NOT NULL, nieruchomosc_id INT DEFAULT NULL, pietro INT NOT NULL, liczba_pieter INT NOT NULL, rok_budowy INT NOT NULL, UNIQUE INDEX UNIQ_79DA2BB7C74FC62D (nieruchomosc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nieruchomosci (id INT AUTO_INCREMENT NOT NULL, miasto_id INT DEFAULT NULL, typ_oferty VARCHAR(5) NOT NULL, powierzchnia DOUBLE PRECISION NOT NULL, cena DOUBLE PRECISION NOT NULL, cena_m2 DOUBLE PRECISION NOT NULL, INDEX IDX_16E054DDD2E14C8B (miasto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nieruchomosci_komunikacja (nieruchomosc_id INT NOT NULL, komunikacja_id INT NOT NULL, INDEX IDX_BBCF0030C74FC62D (nieruchomosc_id), INDEX IDX_BBCF0030DA8337E3 (komunikacja_id), PRIMARY KEY(nieruchomosc_id, komunikacja_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mieszkania ADD CONSTRAINT FK_79DA2BB7C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE nieruchomosci ADD CONSTRAINT FK_16E054DDD2E14C8B FOREIGN KEY (miasto_id) REFERENCES miasta (id)');
        $this->addSql('ALTER TABLE nieruchomosci_komunikacja ADD CONSTRAINT FK_BBCF0030C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE nieruchomosci_komunikacja ADD CONSTRAINT FK_BBCF0030DA8337E3 FOREIGN KEY (komunikacja_id) REFERENCES komunikacja (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nieruchomosci_komunikacja DROP FOREIGN KEY FK_BBCF0030DA8337E3');
        $this->addSql('ALTER TABLE nieruchomosci DROP FOREIGN KEY FK_16E054DDD2E14C8B');
        $this->addSql('ALTER TABLE mieszkania DROP FOREIGN KEY FK_79DA2BB7C74FC62D');
        $this->addSql('ALTER TABLE nieruchomosci_komunikacja DROP FOREIGN KEY FK_BBCF0030C74FC62D');
        $this->addSql('DROP TABLE komunikacja');
        $this->addSql('DROP TABLE miasta');
        $this->addSql('DROP TABLE mieszkania');
        $this->addSql('DROP TABLE nieruchomosci');
        $this->addSql('DROP TABLE nieruchomosci_komunikacja');
    }
}
