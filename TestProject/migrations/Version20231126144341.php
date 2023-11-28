<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126144341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE circuit (id INT AUTO_INCREMENT NOT NULL, destination_id INT DEFAULT NULL, prix INT NOT NULL, depart VARCHAR(255) NOT NULL, arrive VARCHAR(255) NOT NULL, temps VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, INDEX IDX_1325F3A6816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination (iddest INT AUTO_INCREMENT NOT NULL, countries VARCHAR(255) NOT NULL, PRIMARY KEY(iddest)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE circuit ADD CONSTRAINT FK_1325F3A6816C6140 FOREIGN KEY (destination_id) REFERENCES destination (iddest)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE circuit DROP FOREIGN KEY FK_1325F3A6816C6140');
        $this->addSql('DROP TABLE circuit');
        $this->addSql('DROP TABLE destination');
    }
}
