<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401120648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services ADD preview_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169CDE46FDB FOREIGN KEY (preview_id) REFERENCES attachments (id)');
        $this->addSql('CREATE INDEX IDX_7332E169CDE46FDB ON services (preview_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169CDE46FDB');
        $this->addSql('DROP INDEX IDX_7332E169CDE46FDB ON services');
        $this->addSql('ALTER TABLE services DROP preview_id');
    }
}
