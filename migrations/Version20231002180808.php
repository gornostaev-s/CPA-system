<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002180808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lead_query_offers CHANGE lead_query_id lead_query_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD telegram_key LONGTEXT NOT NULL, ADD telegram_id LONGTEXT DEFAULT NULL, CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flow_subscription CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE lead_query_offers CHANGE lead_query_id lead_query_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP telegram_key, DROP telegram_id, CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
