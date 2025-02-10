<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208140204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiary ADD nature_piece_identite VARCHAR(10) DEFAULT NULL, DROP naturePieceIdentite, CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiary ADD naturePieceIdentite VARCHAR(15) NOT NULL, DROP nature_piece_identite, CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
