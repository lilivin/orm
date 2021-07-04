<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511203404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE miasta ADD powiat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE miasta ADD CONSTRAINT FK_35410348C05AA04F FOREIGN KEY (powiat_id) REFERENCES powiaty (id)');
        $this->addSql('CREATE INDEX IDX_35410348C05AA04F ON miasta (powiat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE miasta DROP FOREIGN KEY FK_35410348C05AA04F');
        $this->addSql('DROP INDEX IDX_35410348C05AA04F ON miasta');
        $this->addSql('ALTER TABLE miasta DROP powiat_id');
    }
}
