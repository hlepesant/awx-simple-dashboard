<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210123940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE awx_job ADD customer_id INT NOT NULL');
        $this->addSql('ALTER TABLE awx_job ADD application_id INT NOT NULL');
        $this->addSql('ALTER TABLE awx_job ADD CONSTRAINT FK_F8DF28469395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE awx_job ADD CONSTRAINT FK_F8DF28463E030ACD FOREIGN KEY (application_id) REFERENCES application (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F8DF28469395C3F3 ON awx_job (customer_id)');
        $this->addSql('CREATE INDEX IDX_F8DF28463E030ACD ON awx_job (application_id)');
        $this->addSql('ALTER TABLE customer ADD silo_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09C9902A61 FOREIGN KEY (silo_id) REFERENCES silo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_81398E09C9902A61 ON customer (silo_id)');
        $this->addSql('ALTER TABLE silo ADD inventory_id INT NOT NULL');
        $this->addSql('ALTER TABLE silo ADD time_zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE silo ADD CONSTRAINT FK_B8D78A39EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE silo ADD CONSTRAINT FK_B8D78A3CBAB9ECD FOREIGN KEY (time_zone_id) REFERENCES time_zone (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B8D78A39EEA759 ON silo (inventory_id)');
        $this->addSql('CREATE INDEX IDX_B8D78A3CBAB9ECD ON silo (time_zone_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA awx');
        $this->addSql('ALTER TABLE awx_job DROP CONSTRAINT FK_F8DF28469395C3F3');
        $this->addSql('ALTER TABLE awx_job DROP CONSTRAINT FK_F8DF28463E030ACD');
        $this->addSql('DROP INDEX IDX_F8DF28469395C3F3');
        $this->addSql('DROP INDEX IDX_F8DF28463E030ACD');
        $this->addSql('ALTER TABLE awx_job DROP customer_id');
        $this->addSql('ALTER TABLE awx_job DROP application_id');
        $this->addSql('ALTER TABLE customer DROP CONSTRAINT FK_81398E09C9902A61');
        $this->addSql('DROP INDEX IDX_81398E09C9902A61');
        $this->addSql('ALTER TABLE customer DROP silo_id');
        $this->addSql('ALTER TABLE silo DROP CONSTRAINT FK_B8D78A39EEA759');
        $this->addSql('ALTER TABLE silo DROP CONSTRAINT FK_B8D78A3CBAB9ECD');
        $this->addSql('DROP INDEX IDX_B8D78A39EEA759');
        $this->addSql('DROP INDEX IDX_B8D78A3CBAB9ECD');
        $this->addSql('ALTER TABLE silo DROP inventory_id');
        $this->addSql('ALTER TABLE silo DROP time_zone_id');
    }
}
