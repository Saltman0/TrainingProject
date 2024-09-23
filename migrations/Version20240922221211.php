<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240922221211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_seat (id INT AUTO_INCREMENT NOT NULL, booking_id INT NOT NULL, seat_id INT NOT NULL, INDEX IDX_25CD14283301C60 (booking_id), INDEX IDX_25CD1428C1DAFE35 (seat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cinema (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, open_hour TIME NOT NULL, close_hour TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, cinema_id INT NOT NULL, number SMALLINT NOT NULL, projection_quality VARCHAR(255) NOT NULL, INDEX IDX_1B8FA83FB4CB84B6 (cinema_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_3D03A11A52AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, minimum_age INT NOT NULL, favorite TINYINT(1) NOT NULL, INDEX IDX_1D5EF26F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, movie_id INT NOT NULL, user_id INT NOT NULL, number INT NOT NULL, validated TINYINT(1) NOT NULL, INDEX IDX_D88926228F93B6FC (movie_id), INDEX IDX_D8892622A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seat (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, row VARCHAR(255) NOT NULL, number INT NOT NULL, INDEX IDX_3D5C366652AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, movie_id INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, price INT NOT NULL, INDEX IDX_D044D5D452AFCFD6 (hall_id), INDEX IDX_D044D5D48F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE booking_seat ADD CONSTRAINT FK_25CD14283301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE booking_seat ADD CONSTRAINT FK_25CD1428C1DAFE35 FOREIGN KEY (seat_id) REFERENCES seat (id)');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83FB4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinema (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_1D5EF26F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926228F93B6FC FOREIGN KEY (movie_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE seat ADD CONSTRAINT FK_3D5C366652AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D452AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D48F93B6FC FOREIGN KEY (movie_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE613FECDF');
        $this->addSql('ALTER TABLE booking_seat DROP FOREIGN KEY FK_25CD14283301C60');
        $this->addSql('ALTER TABLE booking_seat DROP FOREIGN KEY FK_25CD1428C1DAFE35');
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83FB4CB84B6');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A52AFCFD6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_1D5EF26F12469DE2');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926228F93B6FC');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A76ED395');
        $this->addSql('ALTER TABLE seat DROP FOREIGN KEY FK_3D5C366652AFCFD6');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D452AFCFD6');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D48F93B6FC');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_seat');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE cinema');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE seat');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
