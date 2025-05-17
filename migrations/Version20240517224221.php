<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240517224221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, dossier_id INT NOT NULL, type_document_id INT NOT NULL, date_document DATETIME NOT NULL, fichier VARCHAR(255) NOT NULL, INDEX IDX_D8698A76611C0C56 (dossier_id), INDEX IDX_D8698A768826AFA6 (type_document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier_medical (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A768826AFA6 FOREIGN KEY (type_document_id) REFERENCES type_document (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76611C0C56');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A768826AFA6');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE type_document');
    }
}
