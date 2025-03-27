<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325194350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__work_experience AS SELECT id, primary_data_id, company, position, date_from, date_to FROM work_experience');
        $this->addSql('DROP TABLE work_experience');
        $this->addSql('CREATE TABLE work_experience (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, primary_data_id INTEGER NOT NULL, company VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, date_from DATE NOT NULL, date_to DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_1EF36CD0FC6CE508 FOREIGN KEY (primary_data_id) REFERENCES primary_data (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO work_experience (id, primary_data_id, company, position, date_from, date_to) SELECT id, primary_data_id, company, position, date_from, date_to FROM __temp__work_experience');
        $this->addSql('DROP TABLE __temp__work_experience');
        $this->addSql('CREATE INDEX IDX_1EF36CD0FC6CE508 ON work_experience (primary_data_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__work_experience AS SELECT id, primary_data_id, company, position, date_from, date_to FROM work_experience');
        $this->addSql('DROP TABLE work_experience');
        $this->addSql('CREATE TABLE work_experience (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, primary_data_id INTEGER NOT NULL, company VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, date_from VARCHAR(10) NOT NULL, date_to VARCHAR(10) NOT NULL, CONSTRAINT FK_1EF36CD0FC6CE508 FOREIGN KEY (primary_data_id) REFERENCES primary_data (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO work_experience (id, primary_data_id, company, position, date_from, date_to) SELECT id, primary_data_id, company, position, date_from, date_to FROM __temp__work_experience');
        $this->addSql('DROP TABLE __temp__work_experience');
        $this->addSql('CREATE INDEX IDX_1EF36CD0FC6CE508 ON work_experience (primary_data_id)');
    }
}
