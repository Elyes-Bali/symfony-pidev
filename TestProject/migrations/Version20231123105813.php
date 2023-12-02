<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123105813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_Commentaire_post');
        $this->addSql('ALTER TABLE reponsereclamation DROP FOREIGN KEY reponsereclamation_ibfk_1');
        $this->addSql('DROP TABLE circuit');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponsereclamation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE categories CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY fk_categorie');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY fk_categorie');
        $this->addSql('ALTER TABLE evenements CHANGE dateDebut datedebut DATE NOT NULL, CHANGE description description VARCHAR(250) NOT NULL, CHANGE lieu lieu VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE tarif tarif VARCHAR(255) NOT NULL, CHANGE places_disponibles places_disponibles INT NOT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('DROP INDEX fk_categorie ON evenements');
        $this->addSql('CREATE INDEX IDX_E10AD400BCF5E72D ON evenements (categorie_id)');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT fk_categorie FOREIGN KEY (categorie_id) REFERENCES categories (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE participants CHANGE nom nom INT NOT NULL, CHANGE prenom prenom INT NOT NULL, CHANGE email email INT NOT NULL, CHANGE telephone telephone INT NOT NULL');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY fk_evenement_reservation');
        $this->addSql('DROP INDEX fk_participant_reservation ON reservations');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY fk_evenement_reservation');
        $this->addSql('ALTER TABLE reservations CHANGE places_reservees places_reservees INT NOT NULL, CHANGE participant_id participant_id INT NOT NULL, CHANGE dateheure_reservation dateheure_reservation DATETIME NOT NULL, CHANGE validate validate TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenements (id)');
        $this->addSql('DROP INDEX fk_evenement_reservation ON reservations');
        $this->addSql('CREATE INDEX IDX_4DA239FD02F13 ON reservations (evenement_id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT fk_evenement_reservation FOREIGN KEY (evenement_id) REFERENCES evenements (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE circuit (id INT AUTO_INCREMENT NOT NULL, prix INT NOT NULL, depart VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, arrive VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, temps VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, pays VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire (id_coment INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, contenu TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dateNow DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX fk_Commentaire_post (post_id), PRIMARY KEY(id_coment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, sujet TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reclamation (idRec INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, textRec VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idU INT NOT NULL, emailU VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX idU (idU), INDEX emailU (emailU), PRIMARY KEY(idRec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reponsereclamation (idU INT NOT NULL, Prenom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, intitule VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, textRepRec VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idRec INT NOT NULL, idRepRec INT AUTO_INCREMENT NOT NULL, INDEX textRec (intitule), INDEX Prenom (Prenom), INDEX idU (idU), INDEX idRec (idRec), PRIMARY KEY(idRepRec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, client_id INT NOT NULL, debutReservartion DATE DEFAULT NULL, INDEX transport_id (transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, cap INT NOT NULL, type VARCHAR(33) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dd VARCHAR(33) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, da VARCHAR(33) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (idU INT AUTO_INCREMENT NOT NULL, Nom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Prenom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, tel INT NOT NULL, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, gender VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, Role VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idU)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_Commentaire_post FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE reponsereclamation ADD CONSTRAINT reponsereclamation_ibfk_1 FOREIGN KEY (idRec) REFERENCES reclamation (idRec)');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE categories CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400BCF5E72D');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400BCF5E72D');
        $this->addSql('ALTER TABLE evenements CHANGE datedebut dateDebut DATE DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE lieu lieu VARCHAR(255) DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE tarif tarif NUMERIC(10, 2) DEFAULT NULL, CHANGE places_disponibles places_disponibles INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT fk_categorie FOREIGN KEY (categorie_id) REFERENCES categories (id) ON DELETE SET NULL');
        $this->addSql('DROP INDEX idx_e10ad400bcf5e72d ON evenements');
        $this->addSql('CREATE INDEX fk_categorie ON evenements (categorie_id)');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE participants CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239FD02F13');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239FD02F13');
        $this->addSql('ALTER TABLE reservations CHANGE places_reservees places_reservees INT DEFAULT NULL, CHANGE participant_id participant_id INT DEFAULT NULL, CHANGE dateheure_reservation dateheure_reservation DATETIME DEFAULT NULL, CHANGE validate validate TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT fk_evenement_reservation FOREIGN KEY (evenement_id) REFERENCES evenements (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_participant_reservation ON reservations (participant_id)');
        $this->addSql('DROP INDEX idx_4da239fd02f13 ON reservations');
        $this->addSql('CREATE INDEX fk_evenement_reservation ON reservations (evenement_id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenements (id)');
    }
}
