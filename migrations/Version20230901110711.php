<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230901110711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('SET FOREIGN_KEY_CHECKS=0');
        $this->addSql('CREATE TABLE lead_queries (id INT AUTO_INCREMENT NOT NULL, flow_id INT DEFAULT NULL, category_id INT DEFAULT NULL, region_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, resolved TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_D3361B1C7EB60D1B (flow_id), INDEX IDX_D3361B1C12469DE2 (category_id), INDEX IDX_D3361B1C98260155 (region_id), INDEX IDX_D3361B1C7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lead_queries ADD CONSTRAINT FK_D3361B1C7EB60D1B FOREIGN KEY (flow_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE lead_queries ADD CONSTRAINT FK_D3361B1C12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE lead_queries ADD CONSTRAINT FK_D3361B1C98260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE lead_queries ADD CONSTRAINT FK_D3361B1C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE flow_subscription CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE flows ADD CONSTRAINT FK_4B597EE112469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE flows ADD CONSTRAINT FK_4B597EE198260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE flows ADD CONSTRAINT FK_4B597EE1953C1C61 FOREIGN KEY (source_id) REFERENCES sources (id)');
        $this->addSql('CREATE INDEX IDX_4B597EE112469DE2 ON flows (category_id)');
        $this->addSql('CREATE INDEX IDX_4B597EE198260155 ON flows (region_id)');
        $this->addSql('CREATE INDEX IDX_4B597EE1953C1C61 ON flows (source_id)');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lead_queries DROP FOREIGN KEY FK_D3361B1C7EB60D1B');
        $this->addSql('ALTER TABLE lead_queries DROP FOREIGN KEY FK_D3361B1C12469DE2');
        $this->addSql('ALTER TABLE lead_queries DROP FOREIGN KEY FK_D3361B1C98260155');
        $this->addSql('ALTER TABLE lead_queries DROP FOREIGN KEY FK_D3361B1C7E3C61F9');
        $this->addSql('DROP TABLE lead_queries');
        $this->addSql('ALTER TABLE flows DROP FOREIGN KEY FK_4B597EE112469DE2');
        $this->addSql('ALTER TABLE flows DROP FOREIGN KEY FK_4B597EE198260155');
        $this->addSql('ALTER TABLE flows DROP FOREIGN KEY FK_4B597EE1953C1C61');
        $this->addSql('DROP INDEX IDX_4B597EE112469DE2 ON flows');
        $this->addSql('DROP INDEX IDX_4B597EE198260155 ON flows');
        $this->addSql('DROP INDEX IDX_4B597EE1953C1C61 ON flows');
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE flow_subscription CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
