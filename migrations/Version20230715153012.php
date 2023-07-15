<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230715153012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE summer_match DROP FOREIGN KEY FK_8C1C650EFC53D4E9');
        $this->addSql('ALTER TABLE summer_match ADD CONSTRAINT FK_8C1C650EFC53D4E9 FOREIGN KEY (winner_id_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE summer_match DROP FOREIGN KEY FK_8C1C650EFC53D4E9');
        $this->addSql('ALTER TABLE summer_match ADD CONSTRAINT FK_8C1C650EFC53D4E9 FOREIGN KEY (winner_id_id) REFERENCES team_summer_match (ID)');
    }
}
