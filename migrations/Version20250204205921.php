<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204205921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank CHANGE npcontact npcontact VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank CHANGE npcontact npcontact VARCHAR(25) NOT NULL');
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
