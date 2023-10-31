<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231031205833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lead_import (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flow_subscription CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE lead_queries DROP INDEX UNIQ_D3361B1C7EB60D1B, ADD INDEX IDX_D3361B1C7EB60D1B (flow_id)');
        $this->addSql('ALTER TABLE lead_query_offers ADD CONSTRAINT FK_F84343227EB60D1B FOREIGN KEY (flow_id) REFERENCES flows (id)');
        $this->addSql('ALTER TABLE lead_query_offers ADD CONSTRAINT FK_F843432245C7ED9A FOREIGN KEY (lead_query_id) REFERENCES lead_queries (id)');
        $this->addSql('CREATE INDEX IDX_F84343227EB60D1B ON lead_query_offers (flow_id)');
        $this->addSql('CREATE INDEX IDX_F843432245C7ED9A ON lead_query_offers (lead_query_id)');
        $this->addSql('ALTER TABLE telegram_session ADD CONSTRAINT FK_8B02B422A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B02B422A76ED395 ON telegram_session (user_id)');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lead_import');
        $this->addSql('ALTER TABLE flow_subscription CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE lead_queries DROP INDEX IDX_D3361B1C7EB60D1B, ADD UNIQUE INDEX UNIQ_D3361B1C7EB60D1B (flow_id)');
        $this->addSql('ALTER TABLE lead_query_offers DROP FOREIGN KEY FK_F84343227EB60D1B');
        $this->addSql('ALTER TABLE lead_query_offers DROP FOREIGN KEY FK_F843432245C7ED9A');
        $this->addSql('DROP INDEX IDX_F84343227EB60D1B ON lead_query_offers');
        $this->addSql('DROP INDEX IDX_F843432245C7ED9A ON lead_query_offers');
        $this->addSql('ALTER TABLE telegram_session DROP FOREIGN KEY FK_8B02B422A76ED395');
        $this->addSql('DROP INDEX UNIQ_8B02B422A76ED395 ON telegram_session');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
