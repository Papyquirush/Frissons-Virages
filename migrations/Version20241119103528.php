<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119103528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coasters (id INT AUTO_INCREMENT NOT NULL, material_type_id INT NOT NULL, seating_type_id INT NOT NULL, model_id INT NOT NULL, manufacturer_id INT NOT NULL, restraint_id INT NOT NULL, park_id INT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, speed INT NOT NULL, height INT NOT NULL, length INT NOT NULL, inversions_number INT NOT NULL, opening_date DATETIME NOT NULL, total_ratings INT NOT NULL, valid_duels INT NOT NULL, score NUMERIC(10, 8) NOT NULL, rank INT NOT NULL, main_image VARCHAR(255) NOT NULL, INDEX IDX_4526072F74D6573C (material_type_id), INDEX IDX_4526072F343629B2 (seating_type_id), INDEX IDX_4526072F7975B7E7 (model_id), INDEX IDX_4526072FA23B42D (manufacturer_id), INDEX IDX_4526072F950622D7 (restraint_id), INDEX IDX_4526072F44990C25 (park_id), INDEX IDX_4526072F6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coaster_launches (coaster_id INT NOT NULL, launches_id INT NOT NULL, INDEX IDX_CC490B52216303C (coaster_id), INDEX IDX_CC490B529F98DE6C (launches_id), PRIMARY KEY(coaster_id, launches_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE launches (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materialType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parks (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restraint (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seatingType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_coaster (user_id INT NOT NULL, coaster_id INT NOT NULL, INDEX IDX_AE3C3472A76ED395 (user_id), INDEX IDX_AE3C3472216303C (coaster_id), PRIMARY KEY(user_id, coaster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_park (user_id INT NOT NULL, park_id INT NOT NULL, INDEX IDX_BE8631FAA76ED395 (user_id), INDEX IDX_BE8631FA44990C25 (park_id), PRIMARY KEY(user_id, park_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F74D6573C FOREIGN KEY (material_type_id) REFERENCES materialType (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F343629B2 FOREIGN KEY (seating_type_id) REFERENCES seatingType (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072FA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F950622D7 FOREIGN KEY (restraint_id) REFERENCES restraint (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F44990C25 FOREIGN KEY (park_id) REFERENCES parks (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE coaster_launches ADD CONSTRAINT FK_CC490B52216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_launches ADD CONSTRAINT FK_CC490B529F98DE6C FOREIGN KEY (launches_id) REFERENCES launches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_coaster ADD CONSTRAINT FK_AE3C3472A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_coaster ADD CONSTRAINT FK_AE3C3472216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_park ADD CONSTRAINT FK_BE8631FAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_park ADD CONSTRAINT FK_BE8631FA44990C25 FOREIGN KEY (park_id) REFERENCES parks (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F74D6573C');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F343629B2');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F7975B7E7');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072FA23B42D');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F950622D7');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F44990C25');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F6BF700BD');
        $this->addSql('ALTER TABLE coaster_launches DROP FOREIGN KEY FK_CC490B52216303C');
        $this->addSql('ALTER TABLE coaster_launches DROP FOREIGN KEY FK_CC490B529F98DE6C');
        $this->addSql('ALTER TABLE user_coaster DROP FOREIGN KEY FK_AE3C3472A76ED395');
        $this->addSql('ALTER TABLE user_coaster DROP FOREIGN KEY FK_AE3C3472216303C');
        $this->addSql('ALTER TABLE user_park DROP FOREIGN KEY FK_BE8631FAA76ED395');
        $this->addSql('ALTER TABLE user_park DROP FOREIGN KEY FK_BE8631FA44990C25');
        $this->addSql('DROP TABLE coasters');
        $this->addSql('DROP TABLE coaster_launches');
        $this->addSql('DROP TABLE launches');
        $this->addSql('DROP TABLE manufacturer');
        $this->addSql('DROP TABLE materialType');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE parks');
        $this->addSql('DROP TABLE restraint');
        $this->addSql('DROP TABLE seatingType');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_coaster');
        $this->addSql('DROP TABLE user_park');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
