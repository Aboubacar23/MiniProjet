<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200426150128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, document VARCHAR(255) NOT NULL, date_publication DATE NOT NULL, INDEX IDX_AF3C67796A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, statut_id INT DEFAULT NULL, equipe_id INT DEFAULT NULL, etablissement_id INT DEFAULT NULL, cin INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_F6B4FB29F6203804 (statut_id), INDEX IDX_F6B4FB296D861B89 (equipe_id), INDEX IDX_F6B4FB29FF631228 (etablissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, objet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67796A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB296D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29F6203804');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67796A99F74A');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29FF631228');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB296D861B89');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE equipe');
    }
}
