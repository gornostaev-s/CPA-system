<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122131556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE lead_import ADD flow_id_field VARCHAR(255) NOT NULL, ADD name_field VARCHAR(255) NOT NULL, ADD phone_field VARCHAR(255) NOT NULL, ADD region_field VARCHAR(255) NOT NULL, ADD comment_field VARCHAR(255) NOT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE lead_import DROP flow_id_field, DROP name_field, DROP phone_field, DROP region_field, DROP comment_field, DROP created_at');
    }
}
