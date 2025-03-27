<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323091135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, primary_data_id INTEGER NOT NULL, phone_number VARCHAR(15) NOT NULL, email_address VARCHAR(255) NOT NULL, CONSTRAINT FK_E8092A0BFC6CE508 FOREIGN KEY (primary_data_id) REFERENCES primary_data (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8092A0BFC6CE508 ON contact_details (primary_data_id)');
        $this->addSql('CREATE TABLE primary_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, birth_date VARCHAR(10) NOT NULL)');
        $this->addSql('CREATE TABLE work_experience (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, primary_data_id INTEGER NOT NULL, company VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, date_from VARCHAR(10) NOT NULL, date_to VARCHAR(10) NOT NULL, CONSTRAINT FK_1EF36CD0FC6CE508 FOREIGN KEY (primary_data_id) REFERENCES primary_data (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1EF36CD0FC6CE508 ON work_experience (primary_data_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact_details');
        $this->addSql('DROP TABLE primary_data');
        $this->addSql('DROP TABLE work_experience');
    }
}
