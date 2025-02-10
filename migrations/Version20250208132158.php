<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208132158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loc DROP FOREIGN KEY fk_loc_countries');
        $this->addSql('ALTER TABLE loc DROP FOREIGN KEY fk_loc_cities');
        $this->addSql('DROP TABLE loc');
        $this->addSql('ALTER TABLE beneficiary DROP FOREIGN KEY FK_7ABF446A8BAC62AF');
        $this->addSql('DROP INDEX IDX_7ABF446A8BAC62AF ON beneficiary');
        $this->addSql('ALTER TABLE beneficiary ADD id_number VARCHAR(50) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0\' NOT NULL, CHANGE place_of_birth city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE beneficiary ADD CONSTRAINT FK_7ABF446A8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_7ABF446A8BAC62AF ON beneficiary (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loc (id INT AUTO_INCREMENT NOT NULL, fk_countries INT NOT NULL, fk_cities INT NOT NULL, name_loc VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, latitude NUMERIC(10, 8) NOT NULL, longitude NUMERIC(11, 8) NOT NULL, INDEX idx_countries (fk_countries), INDEX idx_cities (fk_cities), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE loc ADD CONSTRAINT fk_loc_countries FOREIGN KEY (fk_countries) REFERENCES countries (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loc ADD CONSTRAINT fk_loc_cities FOREIGN KEY (fk_cities) REFERENCES cities (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE beneficiary DROP FOREIGN KEY FK_7ABF446A8BAC62AF');
        $this->addSql('DROP INDEX IDX_7ABF446A8BAC62AF ON beneficiary');
        $this->addSql('ALTER TABLE beneficiary DROP id_number, CHANGE histo histo NUMERIC(7, 2) DEFAULT \'0.00\' NOT NULL, CHANGE status status VARCHAR(10) DEFAULT NULL, CHANGE city_id place_of_birth INT DEFAULT NULL');
        $this->addSql('ALTER TABLE beneficiary ADD CONSTRAINT FK_7ABF446A8BAC62AF FOREIGN KEY (place_of_birth) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_7ABF446A8BAC62AF ON beneficiary (place_of_birth)');
    }
}
