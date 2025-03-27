<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325192947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__primary_data AS SELECT id, first_name, last_name, birth_date FROM primary_data');
        $this->addSql('DROP TABLE primary_data');
        $this->addSql('CREATE TABLE primary_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, birth_date DATE NOT NULL)');
        $this->addSql('INSERT INTO primary_data (id, first_name, last_name, birth_date) SELECT id, first_name, last_name, birth_date FROM __temp__primary_data');
        $this->addSql('DROP TABLE __temp__primary_data');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__primary_data AS SELECT id, first_name, last_name, birth_date FROM primary_data');
        $this->addSql('DROP TABLE primary_data');
        $this->addSql('CREATE TABLE primary_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, birth_date VARCHAR(10) NOT NULL)');
        $this->addSql('INSERT INTO primary_data (id, first_name, last_name, birth_date) SELECT id, first_name, last_name, birth_date FROM __temp__primary_data');
        $this->addSql('DROP TABLE __temp__primary_data');
    }
}
