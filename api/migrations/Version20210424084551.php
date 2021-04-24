<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210424084551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', car_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', car_part_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', actioned_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', cost DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, vendor VARCHAR(255) DEFAULT NULL, distance INT DEFAULT NULL, INDEX IDX_47CC8C92C3C6F69F (car_id), INDEX IDX_47CC8C921F48B030 (car_part_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C921F48B030 FOREIGN KEY (car_part_id) REFERENCES car_part (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE action');
    }
}
