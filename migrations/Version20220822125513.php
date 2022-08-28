<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822125513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_reservation (id INT AUTO_INCREMENT NOT NULL, reference_reservation_id INT NOT NULL, date DATE NOT NULL, guest_number INT NOT NULL, hour TIME NOT NULL, options VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_DFD2005CE1A252C5 (reference_reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, id_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_aemporter (id INT AUTO_INCREMENT NOT NULL, reference_commande_id INT NOT NULL, hour TIME NOT NULL, status VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_EB7892C564DD6C60 (reference_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_ligne (id INT AUTO_INCREMENT NOT NULL, plat_id INT NOT NULL, commande_aemporter_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_6E980440D73DB560 (plat_id), INDEX IDX_6E980440EC8C80E6 (commande_aemporter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_ligne_plat (commande_ligne_id INT NOT NULL, plat_id INT NOT NULL, INDEX IDX_A2F2B2638C6396EC (commande_ligne_id), INDEX IDX_A2F2B263D73DB560 (plat_id), PRIMARY KEY(commande_ligne_id, plat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formule (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, date_creation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, formule_number_id INT DEFAULT NULL, plat_jour_number_id INT DEFAULT NULL, category_number_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description TINYTEXT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_2038A207ADFAC56 (formule_number_id), INDEX IDX_2038A2078F88CD0B (plat_jour_number_id), INDEX IDX_2038A207F7C10C20 (category_number_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat_jour (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, date_creation DATE NOT NULL, status TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, telephone INT NOT NULL, gender VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, date_creation DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin_reservation ADD CONSTRAINT FK_DFD2005CE1A252C5 FOREIGN KEY (reference_reservation_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande_aemporter ADD CONSTRAINT FK_EB7892C564DD6C60 FOREIGN KEY (reference_commande_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande_ligne ADD CONSTRAINT FK_6E980440D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id)');
        $this->addSql('ALTER TABLE commande_ligne ADD CONSTRAINT FK_6E980440EC8C80E6 FOREIGN KEY (commande_aemporter_id) REFERENCES commande_aemporter (id)');
        $this->addSql('ALTER TABLE commande_ligne_plat ADD CONSTRAINT FK_A2F2B2638C6396EC FOREIGN KEY (commande_ligne_id) REFERENCES commande_ligne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_ligne_plat ADD CONSTRAINT FK_A2F2B263D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207ADFAC56 FOREIGN KEY (formule_number_id) REFERENCES formule (id)');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A2078F88CD0B FOREIGN KEY (plat_jour_number_id) REFERENCES plat_jour (id)');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207F7C10C20 FOREIGN KEY (category_number_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_reservation DROP FOREIGN KEY FK_DFD2005CE1A252C5');
        $this->addSql('ALTER TABLE commande_aemporter DROP FOREIGN KEY FK_EB7892C564DD6C60');
        $this->addSql('ALTER TABLE commande_ligne DROP FOREIGN KEY FK_6E980440D73DB560');
        $this->addSql('ALTER TABLE commande_ligne DROP FOREIGN KEY FK_6E980440EC8C80E6');
        $this->addSql('ALTER TABLE commande_ligne_plat DROP FOREIGN KEY FK_A2F2B2638C6396EC');
        $this->addSql('ALTER TABLE commande_ligne_plat DROP FOREIGN KEY FK_A2F2B263D73DB560');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207ADFAC56');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A2078F88CD0B');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207F7C10C20');
        $this->addSql('DROP TABLE admin_reservation');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE commande_aemporter');
        $this->addSql('DROP TABLE commande_ligne');
        $this->addSql('DROP TABLE commande_ligne_plat');
        $this->addSql('DROP TABLE formule');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE plat_jour');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
