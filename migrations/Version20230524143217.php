<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524143217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flow_subscription (id INT AUTO_INCREMENT NOT NULL, subscriber_id INT NOT NULL, flow_id INT NOT NULL, leads_count INT NOT NULL, INDEX IDX_ECA090F77EB60D1B (flow_id), INDEX IDX_ECA090F77808B1AD (subscriber_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flow_subscription ADD CONSTRAINT FK_ECA090F77EB60D1B FOREIGN KEY (flow_id) REFERENCES flows (id)');
        $this->addSql('ALTER TABLE flow_subscription ADD CONSTRAINT FK_ECA090F77808B1AD FOREIGN KEY (subscriber_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flow_subscription DROP FOREIGN KEY FK_ECA090F77EB60D1B');
        $this->addSql('ALTER TABLE flow_subscription DROP FOREIGN KEY FK_ECA090F77808B1AD');
        $this->addSql('DROP TABLE flow_subscription');
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
