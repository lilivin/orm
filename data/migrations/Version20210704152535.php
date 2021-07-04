<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210704152535 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dodatkowe (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domy (id INT AUTO_INCREMENT NOT NULL, nieruchomosc_id INT DEFAULT NULL, powierzchnia_dzialki DOUBLE PRECISION NOT NULL, rok_budowy INT NOT NULL, UNIQUE INDEX UNIQ_2F01EF27C74FC62D (nieruchomosc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grunt (id INT AUTO_INCREMENT NOT NULL, nieruchomosc_id INT DEFAULT NULL, pozwolenie_na_budowe VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_D22A6DE0C74FC62D (nieruchomosc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materialy (id INT AUTO_INCREMENT NOT NULL, nieruchomosc_id INT DEFAULT NULL, nazwa VARCHAR(255) NOT NULL, INDEX IDX_7BC2FFABC74FC62D (nieruchomosc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nieruchomosci_dodatkowe (nieruchomosc_id INT NOT NULL, dodatkowe_id INT NOT NULL, INDEX IDX_E3573BE5C74FC62D (nieruchomosc_id), INDEX IDX_E3573BE586BADF3D (dodatkowe_id), PRIMARY KEY(nieruchomosc_id, dodatkowe_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE powiaty (id INT AUTO_INCREMENT NOT NULL, wojewodztwo_id INT DEFAULT NULL, nazwa VARCHAR(255) NOT NULL, INDEX IDX_AEE5E2F13E8EA8F5 (wojewodztwo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wojewodztwa (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE domy ADD CONSTRAINT FK_2F01EF27C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE grunt ADD CONSTRAINT FK_D22A6DE0C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE materialy ADD CONSTRAINT FK_7BC2FFABC74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe ADD CONSTRAINT FK_E3573BE5C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe ADD CONSTRAINT FK_E3573BE586BADF3D FOREIGN KEY (dodatkowe_id) REFERENCES dodatkowe (id)');
        $this->addSql('ALTER TABLE powiaty ADD CONSTRAINT FK_AEE5E2F13E8EA8F5 FOREIGN KEY (wojewodztwo_id) REFERENCES wojewodztwa (id)');
        $this->addSql('ALTER TABLE miasta ADD powiat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE miasta ADD CONSTRAINT FK_35410348C05AA04F FOREIGN KEY (powiat_id) REFERENCES powiaty (id)');
        $this->addSql('CREATE INDEX IDX_35410348C05AA04F ON miasta (powiat_id)');
        $this->addSql('ALTER TABLE mieszkania DROP INDEX nieruchomosc_id, ADD UNIQUE INDEX UNIQ_79DA2BB7C74FC62D (nieruchomosc_id)');
        $this->addSql('ALTER TABLE mieszkania CHANGE nieruchomosc_id nieruchomosc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nieruchomosci CHANGE miasto_id miasto_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe DROP FOREIGN KEY FK_E3573BE586BADF3D');
        $this->addSql('ALTER TABLE miasta DROP FOREIGN KEY FK_35410348C05AA04F');
        $this->addSql('ALTER TABLE powiaty DROP FOREIGN KEY FK_AEE5E2F13E8EA8F5');
        $this->addSql('DROP TABLE dodatkowe');
        $this->addSql('DROP TABLE domy');
        $this->addSql('DROP TABLE grunt');
        $this->addSql('DROP TABLE materialy');
        $this->addSql('DROP TABLE nieruchomosci_dodatkowe');
        $this->addSql('DROP TABLE powiaty');
        $this->addSql('DROP TABLE wojewodztwa');
        $this->addSql('DROP INDEX IDX_35410348C05AA04F ON miasta');
        $this->addSql('ALTER TABLE miasta DROP powiat_id');
        $this->addSql('ALTER TABLE mieszkania DROP INDEX UNIQ_79DA2BB7C74FC62D, ADD INDEX nieruchomosc_id (nieruchomosc_id)');
        $this->addSql('ALTER TABLE mieszkania CHANGE nieruchomosc_id nieruchomosc_id INT NOT NULL');
        $this->addSql('ALTER TABLE nieruchomosci CHANGE miasto_id miasto_id INT NOT NULL');
    }
}
