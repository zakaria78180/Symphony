<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925130529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE style (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, couleur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE style_album (style_id INT NOT NULL, album_id INT NOT NULL, INDEX IDX_F34D20B8BACD6074 (style_id), INDEX IDX_F34D20B81137ABCF (album_id), PRIMARY KEY(style_id, album_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE style_album ADD CONSTRAINT FK_F34D20B8BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_album ADD CONSTRAINT FK_F34D20B81137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album CHANGE artiste_id artiste_id INT NOT NULL');
        $this->addSql('ALTER TABLE album RENAME INDEX idx_39986e43eab5deb TO IDX_39986E4321D25844');
        $this->addSql('ALTER TABLE morceau CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE style_album DROP FOREIGN KEY FK_F34D20B8BACD6074');
        $this->addSql('ALTER TABLE style_album DROP FOREIGN KEY FK_F34D20B81137ABCF');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE style_album');
        $this->addSql('ALTER TABLE album CHANGE artiste_id artiste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE album RENAME INDEX idx_39986e4321d25844 TO IDX_39986E43EAB5DEB');
        $this->addSql('ALTER TABLE morceau CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
