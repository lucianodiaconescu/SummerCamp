<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705065812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE summer_match (id INT AUTO_INCREMENT NOT NULL, start_date VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_summer_match (team_id INT NOT NULL, summer_match_id INT NOT NULL, INDEX IDX_849A68CC296CD8AE (team_id), INDEX IDX_849A68CC60542B1B (summer_match_id), PRIMARY KEY(team_id, summer_match_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team_summer_match ADD CONSTRAINT FK_849A68CC296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_summer_match ADD CONSTRAINT FK_849A68CC60542B1B FOREIGN KEY (summer_match_id) REFERENCES summer_match (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_summer_match DROP FOREIGN KEY FK_849A68CC296CD8AE');
        $this->addSql('ALTER TABLE team_summer_match DROP FOREIGN KEY FK_849A68CC60542B1B');
        $this->addSql('DROP TABLE summer_match');
        $this->addSql('DROP TABLE team_summer_match');
    }
}
