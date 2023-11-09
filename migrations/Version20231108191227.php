<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108191227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE orders ADD user_id INT DEFAULT NULL, ADD order_data JSON NOT NULL, ADD payment_order_id VARCHAR(255) NOT NULL, CHANGE amount amount NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEA76ED395 ON orders (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('DROP INDEX IDX_E52FFDEEA76ED395 ON orders');
        $this->addSql('ALTER TABLE orders DROP user_id, DROP order_data, DROP payment_order_id, CHANGE amount amount NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
