<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705075054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE summer_match ADD winner_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE summer_match ADD CONSTRAINT FK_8C1C650EFC53D4E9 FOREIGN KEY (winner_id_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_8C1C650EFC53D4E9 ON summer_match (winner_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE summer_match DROP FOREIGN KEY FK_8C1C650EFC53D4E9');
        $this->addSql('DROP INDEX IDX_8C1C650EFC53D4E9 ON summer_match');
        $this->addSql('ALTER TABLE summer_match DROP winner_id_id');
    }
}
