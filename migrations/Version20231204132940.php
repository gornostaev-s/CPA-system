<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204132940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE lead_import ADD file_id INT DEFAULT NULL, ADD status INT NOT NULL');
        $this->addSql('ALTER TABLE lead_import ADD CONSTRAINT FK_E02FB76193CB796C FOREIGN KEY (file_id) REFERENCES attachments (id)');
        $this->addSql('CREATE INDEX IDX_E02FB76193CB796C ON lead_import (file_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE lead_import DROP FOREIGN KEY FK_E02FB76193CB796C');
        $this->addSql('DROP INDEX IDX_E02FB76193CB796C ON lead_import');
        $this->addSql('ALTER TABLE lead_import DROP file_id, DROP status');
    }
}
