<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126145159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, dateDebut DATE DEFAULT NULL, description TEXT DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, tarif NUMERIC(10, 2) DEFAULT NULL, places_disponibles INT DEFAULT NULL, INDEX fk_categorie (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (idRec INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(50) NOT NULL, textRec VARCHAR(500) NOT NULL, idU INT NOT NULL, emailU VARCHAR(255) NOT NULL, INDEX idU (idU), INDEX emailU (emailU), PRIMARY KEY(idRec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponsereclamation (idU INT NOT NULL, Prenom VARCHAR(20) NOT NULL, intitule VARCHAR(500) NOT NULL, textRepRec VARCHAR(500) NOT NULL, idRepRec INT AUTO_INCREMENT NOT NULL, idRec INT DEFAULT NULL, INDEX Prenom (Prenom), INDEX idU (idU), INDEX idRec (idRec), INDEX textRec (intitule), PRIMARY KEY(idRepRec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, client_id INT NOT NULL, debutReservartion DATE DEFAULT NULL, INDEX transport_id (transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, places_reservees INT DEFAULT NULL, participant_id INT DEFAULT NULL, dateheure_reservation DATETIME DEFAULT NULL, validate TINYINT(1) DEFAULT NULL, INDEX fk_evenement_reservation (evenement_id), INDEX fk_participant_reservation (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, cap INT NOT NULL, type VARCHAR(33) NOT NULL, dd VARCHAR(33) NOT NULL, da VARCHAR(33) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (idU INT AUTO_INCREMENT NOT NULL, Nom VARCHAR(20) NOT NULL, Prenom VARCHAR(20) NOT NULL, email VARCHAR(50) NOT NULL, tel INT NOT NULL, mdp VARCHAR(255) NOT NULL, gender VARCHAR(20) DEFAULT NULL, Role VARCHAR(20) DEFAULT NULL, PRIMARY KEY(idU)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE reponsereclamation ADD CONSTRAINT FK_B052BA70454DD7AB FOREIGN KEY (idRec) REFERENCES reclamation (idRec)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenements (id)');
        $this->addSql('ALTER TABLE circuit DROP FOREIGN KEY FK_1325F3A6816C6140');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_Commentaire_post');
        $this->addSql('DROP TABLE circuit');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE destination');
        $this->addSql('ALTER TABLE post CHANGE sujet sujet LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE circuit (id INT AUTO_INCREMENT NOT NULL, destination_id INT DEFAULT NULL, prix INT NOT NULL, depart VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, arrive VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, temps VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, pays VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1325F3A6816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire (id_coment INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, contenu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, datenow VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_67F068BC4B89032C (post_id), PRIMARY KEY(id_coment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE destination (iddest INT AUTO_INCREMENT NOT NULL, countries VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(iddest)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE circuit ADD CONSTRAINT FK_1325F3A6816C6140 FOREIGN KEY (destination_id) REFERENCES destination (iddest)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_Commentaire_post FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400BCF5E72D');
        $this->addSql('ALTER TABLE reponsereclamation DROP FOREIGN KEY FK_B052BA70454DD7AB');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239FD02F13');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE evenements');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponsereclamation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE post CHANGE sujet sujet VARCHAR(255) NOT NULL');
    }
}
