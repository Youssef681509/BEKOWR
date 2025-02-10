<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250209133411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE donor ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE donor ADD CONSTRAINT FK_D7F24097F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_D7F24097F92F3E70 ON donor (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE donor DROP FOREIGN KEY FK_D7F24097F92F3E70');
        $this->addSql('DROP INDEX IDX_D7F24097F92F3E70 ON donor');
        $this->addSql('ALTER TABLE donor DROP country_id');
    }
}
