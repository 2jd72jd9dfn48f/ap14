<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127110552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tour DROP FOREIGN KEY FK_6AD1F9693397707A');
        $this->addSql('DROP INDEX categoria_id ON tour');
        $this->addSql('CREATE INDEX IDX_6AD1F9693397707A ON tour (categoria_id)');
        $this->addSql('ALTER TABLE tour ADD CONSTRAINT FK_6AD1F9693397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tour DROP FOREIGN KEY FK_6AD1F9693397707A');
        $this->addSql('DROP INDEX idx_6ad1f9693397707a ON tour');
        $this->addSql('CREATE INDEX categoria_id ON tour (categoria_id)');
        $this->addSql('ALTER TABLE tour ADD CONSTRAINT FK_6AD1F9693397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
    }
}
