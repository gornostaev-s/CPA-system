<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401110124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachments DROP path, CHANGE image_name image_name LONGTEXT NOT NULL, CHANGE image_original_name image_original_name LONGTEXT NOT NULL, CHANGE image_mime_type image_mime_type LONGTEXT NOT NULL, CHANGE image_size image_size INT NOT NULL, CHANGE image_dimensions image_dimensions JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachments ADD path LONGTEXT NOT NULL, CHANGE image_name image_name VARCHAR(255) DEFAULT NULL, CHANGE image_mime_type image_mime_type VARCHAR(255) DEFAULT NULL, CHANGE image_original_name image_original_name VARCHAR(255) DEFAULT NULL, CHANGE image_dimensions image_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE image_size image_size INT DEFAULT NULL');
    }
}
