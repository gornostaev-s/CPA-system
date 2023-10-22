<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231021190150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('drop index UNIQ_F84343227EB60D1B on lead_query_offers;');
        $this->addSql('drop index UNIQ_F843432245C7ED9A on lead_query_offers;');
    }

    public function down(Schema $schema): void
    {

    }
}
