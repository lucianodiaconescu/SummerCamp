<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713163257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_summer_match ADD team2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team_summer_match ADD CONSTRAINT FK_849A68CCF59E604A FOREIGN KEY (team2_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_849A68CCF59E604A ON team_summer_match (team2_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_summer_match DROP FOREIGN KEY FK_849A68CCF59E604A');
        $this->addSql('DROP INDEX IDX_849A68CCF59E604A ON team_summer_match');
        $this->addSql('ALTER TABLE team_summer_match DROP team2_id');
    }
}
