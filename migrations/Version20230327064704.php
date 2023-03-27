<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327064704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_templates CHANGE name name VARCHAR(255) NOT NULL, CHANGE fields fields JSON NOT NULL, CHANGE template_name template_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pages ADD status INT NOT NULL, ADD published_at DATETIME NOT NULL, ADD created_at DATETIME NOT NULL, ADD deleted TINYINT(1) NOT NULL, CHANGE title title TEXT NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE slug slug LONGTEXT NOT NULL, CHANGE template_id template_id INT NOT NULL, CHANGE vars vars JSON NOT NULL');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E5755DA0FB8 FOREIGN KEY (template_id) REFERENCES page_templates (id)');
        $this->addSql('ALTER TABLE site_settings CHANGE name name VARCHAR(255) NOT NULL, CHANGE value value LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE site_settings CHANGE name name VARCHAR(180) NOT NULL, CHANGE value value TEXT NOT NULL');
        $this->addSql('ALTER TABLE pages DROP FOREIGN KEY FK_2074E5755DA0FB8');
        $this->addSql('DROP INDEX UNIQ_2074E5755DA0FB8 ON pages');
        $this->addSql('ALTER TABLE pages DROP status, DROP published_at, DROP created_at, DROP deleted, CHANGE template_id template_id VARCHAR(180) NOT NULL, CHANGE title title VARCHAR(180) NOT NULL, CHANGE description description VARCHAR(180) NOT NULL, CHANGE slug slug VARCHAR(180) NOT NULL, CHANGE vars vars JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE page_templates CHANGE name name VARCHAR(180) NOT NULL, CHANGE fields fields JSON DEFAULT NULL, CHANGE template_name template_name VARCHAR(180) NOT NULL');
    }
}
