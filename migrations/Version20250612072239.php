<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250612072239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE enemy_type CHANGE pattern pattern VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE item_definition CHANGE item_key item_key VARCHAR(100) NOT NULL, CHANGE effect_type effect_type VARCHAR(100) NOT NULL, CHANGE effect_value effect_value VARCHAR(255) NOT NULL, CHANGE icon_path icon_path VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE level CHANGE name name VARCHAR(100) NOT NULL, CHANGE json_data json_data JSON NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE obstacle_type ADD collision TINYINT(1) NOT NULL, CHANGE dimensions dimensions JSON NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE obstacle_type DROP collision, CHANGE dimensions dimensions LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE enemy_type CHANGE pattern pattern LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE level CHANGE name name VARCHAR(50) NOT NULL, CHANGE json_data json_data LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE item_definition CHANGE item_key item_key VARCHAR(30) NOT NULL, CHANGE effect_type effect_type VARCHAR(30) NOT NULL, CHANGE effect_value effect_value INT NOT NULL, CHANGE icon_path icon_path VARCHAR(255) DEFAULT NULL
        SQL);
    }
}
