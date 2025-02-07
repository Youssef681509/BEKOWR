<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113183746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bank (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(128) NOT NULL, address VARCHAR(148) DEFAULT NULL, city VARCHAR(128) DEFAULT NULL, country VARCHAR(128) DEFAULT NULL, phone1 VARCHAR(50) DEFAULT NULL, phone2 VARCHAR(50) DEFAULT NULL, phone3 VARCHAR(50) DEFAULT NULL, fax VARCHAR(10) DEFAULT NULL, mail VARCHAR(100) DEFAULT NULL, location VARCHAR(120) DEFAULT NULL, rib INT DEFAULT NULL, ext_code VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, obs LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beneficiary (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, civility VARCHAR(40) NOT NULL, date_of_birth DATE DEFAULT NULL, place_of_birth VARCHAR(140) DEFAULT NULL, title_of_id_doc VARCHAR(17) DEFAULT NULL, id_number VARCHAR(50) DEFAULT NULL, don_srv_str_date DATE DEFAULT NULL, category VARCHAR(2) DEFAULT NULL, type VARCHAR(3) DEFAULT NULL, elec_id_doc VARCHAR(128) DEFAULT NULL, enable TINYINT(1) DEFAULT NULL, status VARCHAR(10) DEFAULT NULL, card_type VARCHAR(16) DEFAULT NULL, company_name VARCHAR(128) NOT NULL, address VARCHAR(148) DEFAULT NULL, city VARCHAR(128) DEFAULT NULL, country VARCHAR(128) DEFAULT NULL, phone1 VARCHAR(50) DEFAULT NULL, phone2 VARCHAR(50) DEFAULT NULL, phone3 VARCHAR(50) DEFAULT NULL, fax VARCHAR(10) DEFAULT NULL, mail VARCHAR(100) DEFAULT NULL, location VARCHAR(120) DEFAULT NULL, rib INT DEFAULT NULL, ext_code VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, obs LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE claim (id INT AUTO_INCREMENT NOT NULL, beneficiary_id INT NOT NULL, donor_id INT NOT NULL, date_claim DATE DEFAULT NULL, date_closing DATE DEFAULT NULL, type_of_claim VARCHAR(20) DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, password_claim VARCHAR(10) DEFAULT NULL, status VARCHAR(10) DEFAULT NULL, INDEX IDX_A769DE27ECCAAFA0 (beneficiary_id), INDEX IDX_A769DE273DD7B7A7 (donor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation (id INT AUTO_INCREMENT NOT NULL, donor_id INT NOT NULL, beneficiary_id INT NOT NULL, date_of_donation DATE DEFAULT NULL, date_of_receipt DATE DEFAULT NULL, don_amount DOUBLE PRECISION DEFAULT NULL, don_currency VARCHAR(3) DEFAULT NULL, status_of_donation VARCHAR(10) DEFAULT NULL, payment_method VARCHAR(16) DEFAULT NULL, password_don VARCHAR(10) DEFAULT NULL, ext_code VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, obs LONGTEXT DEFAULT NULL, INDEX IDX_31E581A03DD7B7A7 (donor_id), INDEX IDX_31E581A0ECCAAFA0 (beneficiary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donor (id INT AUTO_INCREMENT NOT NULL, bank_address VARCHAR(140) DEFAULT NULL, company_name VARCHAR(128) NOT NULL, address VARCHAR(148) DEFAULT NULL, city VARCHAR(128) DEFAULT NULL, country VARCHAR(128) DEFAULT NULL, phone1 VARCHAR(50) DEFAULT NULL, phone2 VARCHAR(50) DEFAULT NULL, phone3 VARCHAR(50) DEFAULT NULL, fax VARCHAR(10) DEFAULT NULL, mail VARCHAR(100) DEFAULT NULL, location VARCHAR(120) DEFAULT NULL, rib INT DEFAULT NULL, ext_code VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, obs LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE claim ADD CONSTRAINT FK_A769DE27ECCAAFA0 FOREIGN KEY (beneficiary_id) REFERENCES beneficiary (id)');
        $this->addSql('ALTER TABLE claim ADD CONSTRAINT FK_A769DE273DD7B7A7 FOREIGN KEY (donor_id) REFERENCES donor (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A03DD7B7A7 FOREIGN KEY (donor_id) REFERENCES donor (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0ECCAAFA0 FOREIGN KEY (beneficiary_id) REFERENCES beneficiary (id)');
        $this->addSql('ALTER TABLE user ADD ext_code VARCHAR(10) DEFAULT NULL, CHANGE obrsv obs LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE claim DROP FOREIGN KEY FK_A769DE27ECCAAFA0');
        $this->addSql('ALTER TABLE claim DROP FOREIGN KEY FK_A769DE273DD7B7A7');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A03DD7B7A7');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A0ECCAAFA0');
        $this->addSql('DROP TABLE bank');
        $this->addSql('DROP TABLE beneficiary');
        $this->addSql('DROP TABLE claim');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE donor');
        $this->addSql('ALTER TABLE `user` DROP ext_code, CHANGE obs obrsv LONGTEXT DEFAULT NULL');
    }
}
