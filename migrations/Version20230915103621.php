<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230915103621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lead_query_offers (id INT AUTO_INCREMENT NOT NULL, flow_id INT DEFAULT NULL, lead_query_id INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX UNIQ_F84343227EB60D1B (flow_id), UNIQUE INDEX UNIQ_F843432245C7ED9A (lead_query_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lead_query_offers ADD CONSTRAINT FK_F84343227EB60D1B FOREIGN KEY (flow_id) REFERENCES flows (id)');
        $this->addSql('ALTER TABLE lead_query_offers ADD CONSTRAINT FK_F843432245C7ED9A FOREIGN KEY (lead_query_id) REFERENCES lead_queries (id)');
        $this->addSql('ALTER TABLE lead_queries DROP FOREIGN KEY FK_D3361B1C7EB60D1B');
        $this->addSql('ALTER TABLE lead_queries ADD CONSTRAINT FK_D3361B1C7EB60D1B FOREIGN KEY (flow_id) REFERENCES flows (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lead_query_offers DROP FOREIGN KEY FK_F84343227EB60D1B');
        $this->addSql('ALTER TABLE lead_query_offers DROP FOREIGN KEY FK_F843432245C7ED9A');
        $this->addSql('DROP TABLE lead_query_offers');
        $this->addSql('ALTER TABLE lead_queries DROP FOREIGN KEY FK_D3361B1C7EB60D1B');
        $this->addSql('ALTER TABLE lead_queries ADD CONSTRAINT FK_D3361B1C7EB60D1B FOREIGN KEY (flow_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
