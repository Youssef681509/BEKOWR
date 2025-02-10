<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250209123314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bank ADD CONSTRAINT FK_D860BF7AF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_D860BF7AF92F3E70 ON bank (country_id)');
        $this->addSql('ALTER TABLE beneficiary CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0\' NOT NULL, CHANGE nature_piece_identite nature_piece_identite VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cities CHANGE country_id country_id INT NOT NULL');
        $this->addSql('ALTER TABLE countries DROP code, CHANGE name name VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank DROP FOREIGN KEY FK_D860BF7AF92F3E70');
        $this->addSql('DROP INDEX IDX_D860BF7AF92F3E70 ON bank');
        $this->addSql('ALTER TABLE bank DROP country_id');
        $this->addSql('ALTER TABLE beneficiary CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0.00\' NOT NULL, CHANGE status status VARCHAR(15) DEFAULT NULL, CHANGE nature_piece_identite nature_piece_identite VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE cities CHANGE country_id country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE countries ADD code VARCHAR(10) DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL');
    }
}
