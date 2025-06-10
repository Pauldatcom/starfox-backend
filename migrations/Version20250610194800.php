<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250610194800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE level_event (id INT AUTO_INCREMENT NOT NULL, level_id INT NOT NULL, trigger_z INT NOT NULL, event_type VARCHAR(50) NOT NULL, params LONGTEXT NOT NULL, sequence_order INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_51770FAE5FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE level_event ADD CONSTRAINT FK_51770FAE5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE level_event DROP FOREIGN KEY FK_51770FAE5FB14BA7
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE level_event
        SQL);
    }
}
