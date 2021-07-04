<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511182516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE nieruchomosci_dodatkowe');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nieruchomosci_dodatkowe (nieruchomosc_id INT NOT NULL, dodatkowe_id INT NOT NULL, INDEX IDX_E3573BE586BADF3D (dodatkowe_id), INDEX IDX_E3573BE5C74FC62D (nieruchomosc_id), PRIMARY KEY(nieruchomosc_id, dodatkowe_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe ADD CONSTRAINT FK_E3573BE586BADF3D FOREIGN KEY (dodatkowe_id) REFERENCES dodatkowe (id)');
        $this->addSql('ALTER TABLE nieruchomosci_dodatkowe ADD CONSTRAINT FK_E3573BE5C74FC62D FOREIGN KEY (nieruchomosc_id) REFERENCES nieruchomosci (id)');
    }
}
