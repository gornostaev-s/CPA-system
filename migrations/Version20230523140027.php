<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523140027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE flows (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, region_id INT NOT NULL, source_id INT NOT NULL, what_leads_sold LONGTEXT NOT NULL, description LONGTEXT NOT NULL, rate NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted TINYINT(1) DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leads (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, owner_id INT NOT NULL, delivered_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, phone INT NOT NULL, message LONGTEXT NOT NULL, referer VARCHAR(512) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pages CHANGE title title VARCHAR(512) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE flows');
        $this->addSql('DROP TABLE leads');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE pages CHANGE title title TEXT NOT NULL');
    }
}
