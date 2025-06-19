<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619000708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE crew (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(255) NOT NULL, parent_id INT DEFAULT NULL, INDEX IDX_894940B2727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE crew ADD CONSTRAINT FK_894940B2727ACA70 FOREIGN KEY (parent_id) REFERENCES crew (id) ON DELETE SET NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE crew DROP FOREIGN KEY FK_894940B2727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE crew
        SQL);
    }
}
