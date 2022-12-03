<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221203104958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad ADD ad_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED58D7BD28BD FOREIGN KEY (ad_image_id) REFERENCES ad_image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77E0ED58D7BD28BD ON ad (ad_image_id)');
        $this->addSql('ALTER TABLE ad_image DROP CONSTRAINT FK_F85D5EDA4F34D596');
        $this->addSql('ALTER TABLE ad_image ADD CONSTRAINT FK_F85D5EDA4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ad_image DROP CONSTRAINT fk_f85d5eda4f34d596');
        $this->addSql('ALTER TABLE ad_image ADD CONSTRAINT fk_f85d5eda4f34d596 FOREIGN KEY (ad_id) REFERENCES ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ad DROP CONSTRAINT FK_77E0ED58D7BD28BD');
        $this->addSql('DROP INDEX UNIQ_77E0ED58D7BD28BD');
        $this->addSql('ALTER TABLE ad DROP ad_image_id');
    }
}
