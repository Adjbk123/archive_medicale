<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240517205005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dossier_medical (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, date_creation DATETIME NOT NULL, derniere_mise_ajour DATETIME NOT NULL, UNIQUE INDEX UNIQ_3581EE626B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dossier_medical ADD CONSTRAINT FK_3581EE626B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_medical DROP FOREIGN KEY FK_3581EE626B899279');
        $this->addSql('DROP TABLE dossier_medical');
    }
}
