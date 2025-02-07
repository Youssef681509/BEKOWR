<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250131124224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank DROP FOREIGN KEY FK_D860BF7AF92F3E70');
        $this->addSql('DROP INDEX IDX_D860BF7AF92F3E70 ON bank');
        $this->addSql('ALTER TABLE bank DROP country_id');
        $this->addSql('ALTER TABLE beneficiary DROP FOREIGN KEY FK_7ABF446AF92F3E70');
        $this->addSql('DROP INDEX IDX_7ABF446AF92F3E70 ON beneficiary');
        $this->addSql('ALTER TABLE beneficiary DROP country_id');
        $this->addSql('ALTER TABLE donor DROP FOREIGN KEY FK_D7F24097F92F3E70');
        $this->addSql('DROP INDEX IDX_D7F24097F92F3E70 ON donor');
        $this->addSql('ALTER TABLE donor DROP country_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bank ADD CONSTRAINT FK_D860BF7AF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_D860BF7AF92F3E70 ON bank (country_id)');
        $this->addSql('ALTER TABLE beneficiary ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE beneficiary ADD CONSTRAINT FK_7ABF446AF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_7ABF446AF92F3E70 ON beneficiary (country_id)');
        $this->addSql('ALTER TABLE donor ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE donor ADD CONSTRAINT FK_D7F24097F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_D7F24097F92F3E70 ON donor (country_id)');
    }
}
