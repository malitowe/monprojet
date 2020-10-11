<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201011081226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, sexe VARCHAR(10) DEFAULT NULL, date_naissance DATE DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, confirmationToken VARCHAR(255) DEFAULT NULL, passwordRequestedAt DATETIME DEFAULT NULL, lastLogin DATETIME DEFAULT NULL, roles JSON NOT NULL, email VARCHAR(180) NOT NULL, type_user VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, ville VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, etablissement_id INT DEFAULT NULL, added_by_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8F87BF96FF631228 (etablissement_id), INDEX IDX_8F87BF9655B127A4 (added_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, INDEX IDX_FDCA8C9C8F5EA509 (classe_id), INDEX IDX_FDCA8C9CB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_cours (user_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_1F0877C4A76ED395 (user_id), INDEX IDX_1F0877C47ECF78B0 (cours_id), PRIMARY KEY(user_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, cours_id INT DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_AB55E24FA76ED395 (user_id), INDEX IDX_AB55E24F7ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, cours_id INT DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BD310CCA76ED395 (user_id), INDEX IDX_BD310CC7ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(128) NOT NULL, username VARCHAR(128) NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, locked TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', lastLogin DATETIME DEFAULT NULL, confirmationToken VARCHAR(190) DEFAULT NULL, passwordRequestedAt DATETIME DEFAULT NULL, created_at INT DEFAULT 0 NOT NULL, updated_at INT DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_58DF0651F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF9655B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_cours ADD CONSTRAINT FK_1F0877C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_cours ADD CONSTRAINT FK_1F0877C47ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE enseignement ADD CONSTRAINT FK_BD310CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE enseignement ADD CONSTRAINT FK_BD310CC7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C8F5EA509');
        $this->addSql('ALTER TABLE enseignement DROP FOREIGN KEY FK_BD310CC7ECF78B0');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F7ECF78B0');
        $this->addSql('ALTER TABLE user_cours DROP FOREIGN KEY FK_1F0877C47ECF78B0');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96FF631228');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF9655B127A4');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CB03A8386');
        $this->addSql('ALTER TABLE enseignement DROP FOREIGN KEY FK_BD310CCA76ED395');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('ALTER TABLE user_cours DROP FOREIGN KEY FK_1F0877C4A76ED395');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE enseignement');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_cours');
        $this->addSql('DROP TABLE ville');
    }
}
