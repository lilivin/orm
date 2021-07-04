<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210704150602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE nieruchomosc_komunikacja');
        $this->addSql('ALTER TABLE miasta ADD powiat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE miasta ADD CONSTRAINT FK_35410348C05AA04F FOREIGN KEY (powiat_id) REFERENCES powiaty (id)');
        $this->addSql('CREATE INDEX IDX_35410348C05AA04F ON miasta (powiat_id)');
        $this->addSql('ALTER TABLE mieszkania DROP INDEX nieruchomosc_id, ADD UNIQUE INDEX UNIQ_79DA2BB7C74FC62D (nieruchomosc_id)');
        $this->addSql('ALTER TABLE mieszkania CHANGE nieruchomosc_id nieruchomosc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nieruchomosci CHANGE miasto_id miasto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nieruchomosci_komunikacja ADD CONSTRAINT FK_BBCF0030C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE nieruchomosci_komunikacja ADD CONSTRAINT FK_BBCF0030DA8337E3 FOREIGN KEY (komunikacja_id) REFERENCES komunikacja (id)');
        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe ADD CONSTRAINT FK_E3573BE5C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe ADD CONSTRAINT FK_E3573BE586BADF3D FOREIGN KEY (dodatkowe_id) REFERENCES dodatkowe (id)');
        $this->addSql('ALTER TABLE powiaty ADD CONSTRAINT FK_AEE5E2F13E8EA8F5 FOREIGN KEY (wojewodztwo_id) REFERENCES wojewodztwa (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nieruchomosc_komunikacja (nieruchomosc_id INT NOT NULL, komunikacja_id INT NOT NULL, INDEX IDX_BBCF0030C74FC62D (nieruchomosc_id), INDEX IDX_BBCF0030DA8337E3 (komunikacja_id), PRIMARY KEY(nieruchomosc_id, komunikacja_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE nieruchomosc_komunikacja ADD CONSTRAINT FK_BBCF0030C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
        $this->addSql('ALTER TABLE nieruchomosc_komunikacja ADD CONSTRAINT FK_BBCF0030DA8337E3 FOREIGN KEY (komunikacja_id) REFERENCES komunikacja (id)');
        $this->addSql('ALTER TABLE miasta DROP FOREIGN KEY FK_35410348C05AA04F');
        $this->addSql('DROP INDEX IDX_35410348C05AA04F ON miasta');
        $this->addSql('ALTER TABLE miasta DROP powiat_id');
        $this->addSql('ALTER TABLE mieszkania DROP INDEX UNIQ_79DA2BB7C74FC62D, ADD INDEX nieruchomosc_id (nieruchomosc_id)');
        $this->addSql('ALTER TABLE mieszkania CHANGE nieruchomosc_id nieruchomosc_id INT NOT NULL');
        $this->addSql('ALTER TABLE nieruchomosci CHANGE miasto_id miasto_id INT NOT NULL');
        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe DROP FOREIGN KEY FK_E3573BE5C74FC62D');
        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe DROP FOREIGN KEY FK_E3573BE586BADF3D');
        $this->addSql('ALTER TABLE nieruchomosci_komunikacja DROP FOREIGN KEY FK_BBCF0030C74FC62D');
        $this->addSql('ALTER TABLE nieruchomosci_komunikacja DROP FOREIGN KEY FK_BBCF0030DA8337E3');
        $this->addSql('ALTER TABLE powiaty DROP FOREIGN KEY FK_AEE5E2F13E8EA8F5');
    }
}
