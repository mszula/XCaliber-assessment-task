<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017115204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE player (id VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, age INT NOT NULL, gender VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bonus (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, trigger_name VARCHAR(255) NOT NULL, reward_value INT NOT NULL, reward_type VARCHAR(255) NOT NULL, wagering_multiplier INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id VARCHAR(255) NOT NULL, player_id VARCHAR(255) DEFAULT NULL, bonus_id VARCHAR(255) DEFAULT NULL, currency VARCHAR(3) NOT NULL, initial_value INT NOT NULL, current_value INT NOT NULL, status VARCHAR(8) NOT NULL, type VARCHAR(255) NOT NULL, left_wagering_requirements INT DEFAULT NULL, INDEX IDX_7C68921F99E6F5DF (player_id), INDEX IDX_7C68921F69545666 (bonus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F69545666 FOREIGN KEY (bonus_id) REFERENCES bonus (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F99E6F5DF');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F69545666');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE bonus');
        $this->addSql('DROP TABLE wallet');
    }
}
