<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320124826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE pages (
                        id INT NOT NULL auto_increment, 
                        title VARCHAR(180) NOT NULL, 
                        description VARCHAR(180) NOT NULL, 
                        slug VARCHAR(180) NOT NULL, 
                        template_id VARCHAR(180) NOT NULL, 
                        vars json,
                        PRIMARY KEY(id))'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE pages');
    }
}
