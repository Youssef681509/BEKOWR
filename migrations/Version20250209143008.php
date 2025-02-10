<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250209143008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE donor ADD CONSTRAINT FK_D7F2409711C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id)');
        $this->addSql('DROP INDEX fk_donor_bank ON donor');
        $this->addSql('CREATE INDEX IDX_D7F2409711C8FB41 ON donor (bank_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE donor DROP FOREIGN KEY FK_D7F2409711C8FB41');
        $this->addSql('ALTER TABLE donor DROP FOREIGN KEY FK_D7F2409711C8FB41');
        $this->addSql('DROP INDEX idx_d7f2409711c8fb41 ON donor');
        $this->addSql('CREATE INDEX fk_donor_bank ON donor (bank_id)');
        $this->addSql('ALTER TABLE donor ADD CONSTRAINT FK_D7F2409711C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id)');
    }
}
