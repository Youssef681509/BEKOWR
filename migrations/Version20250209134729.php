<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250209134729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE donor DROP bank_address');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE donor ADD bank_address VARCHAR(140) DEFAULT NULL');
    }
}
