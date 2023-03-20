<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319115353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE page_templates (
                        id INT NOT NULL auto_increment, 
                        name VARCHAR(180) NOT NULL, 
                        fields json NOT NULL default \'[]\', 
                        template_name VARCHAR(180) NOT NULL, 
                        PRIMARY KEY(id))'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE page_templates');
    }
}
