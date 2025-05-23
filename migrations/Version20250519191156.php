<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519191156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
            ALTER TABLE transaction_inventaire DROP FOREIGN KEY FK_DC1F1751806F0F5C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_inventaire DROP FOREIGN KEY FK_DC1F1751FB88E14F
        SQL);
    }
}
