<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209151034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE inventory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE silo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE silo (id INT NOT NULL, name VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, quit VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN silo.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE inventory ADD silo_id INT NOT NULL');
        $this->addSql('ALTER TABLE inventory ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN inventory.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36C9902A61 FOREIGN KEY (silo_id) REFERENCES silo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B12D4A36C9902A61 ON inventory (silo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA awx');
        $this->addSql('ALTER TABLE inventory DROP CONSTRAINT FK_B12D4A36C9902A61');
        $this->addSql('DROP SEQUENCE inventory_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE silo_id_seq CASCADE');
        $this->addSql('DROP TABLE silo');
        $this->addSql('DROP INDEX IDX_B12D4A36C9902A61');
        $this->addSql('ALTER TABLE inventory DROP silo_id');
        $this->addSql('ALTER TABLE inventory DROP created_at');
    }
}
