<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127173933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank DROP city, DROP country');
        $this->addSql('ALTER TABLE beneficiary DROP city, DROP country');
        $this->addSql('ALTER TABLE donor DROP city, DROP country');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank ADD city VARCHAR(128) DEFAULT NULL, ADD country VARCHAR(128) DEFAULT NULL');
        $this->addSql('ALTER TABLE beneficiary ADD city VARCHAR(128) DEFAULT NULL, ADD country VARCHAR(128) DEFAULT NULL');
        $this->addSql('ALTER TABLE donor ADD city VARCHAR(128) DEFAULT NULL, ADD country VARCHAR(128) DEFAULT NULL');
    }
}
