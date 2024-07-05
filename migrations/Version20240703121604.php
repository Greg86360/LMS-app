<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703121604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, formateur_id INT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_FDCA8C9C155D8F51 (formateur_id), INDEX IDX_FDCA8C9C60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etape (id INT AUTO_INCREMENT NOT NULL, cours_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_285F75DD7ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, profil VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C155D8F51 FOREIGN KEY (formateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C155D8F51');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C60BB6FE6');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD7ECF78B0');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE utilisateur');
    }
}
