<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230712082423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE summer_match ADD team_summer_match_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE summer_match ADD CONSTRAINT FK_8C1C650E430A3165 FOREIGN KEY (team_summer_match_id) REFERENCES team_summer_match (id)');
        $this->addSql('CREATE INDEX IDX_8C1C650E430A3165 ON summer_match (team_summer_match_id)');
        $this->addSql('ALTER TABLE team_summer_match ADD match_id INT DEFAULT NULL, DROP summer_match_id, DROP nr_puncte, CHANGE team_id team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team_summer_match ADD CONSTRAINT FK_849A68CC296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team_summer_match ADD CONSTRAINT FK_849A68CC2ABEACD6 FOREIGN KEY (match_id) REFERENCES summer_match (id)');
        $this->addSql('CREATE INDEX IDX_849A68CC296CD8AE ON team_summer_match (team_id)');
        $this->addSql('CREATE INDEX IDX_849A68CC2ABEACD6 ON team_summer_match (match_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE summer_match DROP FOREIGN KEY FK_8C1C650E430A3165');
        $this->addSql('DROP INDEX IDX_8C1C650E430A3165 ON summer_match');
        $this->addSql('ALTER TABLE summer_match DROP team_summer_match_id');
        $this->addSql('ALTER TABLE team_summer_match DROP FOREIGN KEY FK_849A68CC296CD8AE');
        $this->addSql('ALTER TABLE team_summer_match DROP FOREIGN KEY FK_849A68CC2ABEACD6');
        $this->addSql('DROP INDEX IDX_849A68CC296CD8AE ON team_summer_match');
        $this->addSql('DROP INDEX IDX_849A68CC2ABEACD6 ON team_summer_match');
        $this->addSql('ALTER TABLE team_summer_match ADD summer_match_id INT NOT NULL, ADD nr_puncte INT NOT NULL, DROP match_id, CHANGE team_id team_id INT NOT NULL');
    }
}
