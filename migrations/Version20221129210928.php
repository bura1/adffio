<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221129210928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP CONSTRAINT fk_c96e70cf7e3c61f9');
        $this->addSql('DROP INDEX idx_c96e70cf7e3c61f9');
        $this->addSql('ALTER TABLE app RENAME COLUMN owner_id TO user_id');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CFA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C96E70CFA76ED395 ON app (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE app DROP CONSTRAINT FK_C96E70CFA76ED395');
        $this->addSql('DROP INDEX IDX_C96E70CFA76ED395');
        $this->addSql('ALTER TABLE app RENAME COLUMN user_id TO owner_id');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT fk_c96e70cf7e3c61f9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c96e70cf7e3c61f9 ON app (owner_id)');
    }
}
