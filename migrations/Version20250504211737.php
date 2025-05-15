<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250504211737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE emplacement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, catégorie_id INT NOT NULL, fournisseur_id INT NOT NULL, emplacement_id INT NOT NULL, nom VARCHAR(255) NOT NULL, numero_de_serie INT NOT NULL, quantité INT NOT NULL, statut VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B8B4C6F37A2E475A (catégorie_id), UNIQUE INDEX UNIQ_B8B4C6F3670C757F (fournisseur_id), UNIQUE INDEX UNIQ_B8B4C6F3C4598A51 (emplacement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, contact INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transaction_inventaire (id INT AUTO_INCREMENT NOT NULL, equipement_id VARCHAR(255) NOT NULL, utilisateur_id INT NOT NULL, type VARCHAR(255) NOT NULL, quantité INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_DC1F1751806F0F5C (equipement_id), INDEX IDX_DC1F1751FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F37A2E475A FOREIGN KEY (catégorie_id) REFERENCES categorie (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3C4598A51 FOREIGN KEY (emplacement_id) REFERENCES emplacement (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_inventaire ADD CONSTRAINT FK_DC1F1751806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_inventaire ADD CONSTRAINT FK_DC1F1751FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F37A2E475A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3670C757F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3C4598A51
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_inventaire DROP FOREIGN KEY FK_DC1F1751806F0F5C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_inventaire DROP FOREIGN KEY FK_DC1F1751FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE emplacement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE equipement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE fournisseur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transaction_inventaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
