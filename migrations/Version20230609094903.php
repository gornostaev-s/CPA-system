<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609094903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flow_subscription CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE leads ADD subscription_id INT NOT NULL, ADD flow_id INT NOT NULL');
        $this->addSql('ALTER TABLE leads ADD CONSTRAINT FK_179045529A1887DC FOREIGN KEY (subscription_id) REFERENCES flow_subscription (id)');
        $this->addSql('ALTER TABLE leads ADD CONSTRAINT FK_179045526C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE leads ADD CONSTRAINT FK_179045527E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE leads ADD CONSTRAINT FK_179045527EB60D1B FOREIGN KEY (flow_id) REFERENCES flows (id)');
        $this->addSql('CREATE INDEX IDX_179045529A1887DC ON leads (subscription_id)');
        $this->addSql('CREATE INDEX IDX_179045526C755722 ON leads (buyer_id)');
        $this->addSql('CREATE INDEX IDX_179045527E3C61F9 ON leads (owner_id)');
        $this->addSql('CREATE INDEX IDX_179045527EB60D1B ON leads (flow_id)');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flows CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE flow_subscription CHANGE rate rate NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE leads DROP FOREIGN KEY FK_179045529A1887DC');
        $this->addSql('ALTER TABLE leads DROP FOREIGN KEY FK_179045526C755722');
        $this->addSql('ALTER TABLE leads DROP FOREIGN KEY FK_179045527E3C61F9');
        $this->addSql('ALTER TABLE leads DROP FOREIGN KEY FK_179045527EB60D1B');
        $this->addSql('DROP INDEX IDX_179045529A1887DC ON leads');
        $this->addSql('DROP INDEX IDX_179045526C755722 ON leads');
        $this->addSql('DROP INDEX IDX_179045527E3C61F9 ON leads');
        $this->addSql('DROP INDEX IDX_179045527EB60D1B ON leads');
        $this->addSql('ALTER TABLE leads DROP subscription_id, DROP flow_id');
        $this->addSql('ALTER TABLE user CHANGE balance balance NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
