<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119110106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favoritesCoasters (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_72C20C3FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites_coasters_coaster (favorites_coasters_id INT NOT NULL, coaster_id INT NOT NULL, INDEX IDX_BE36181B5073950D (favorites_coasters_id), INDEX IDX_BE36181B216303C (coaster_id), PRIMARY KEY(favorites_coasters_id, coaster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoritesParks (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_A33D680DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites_parks_park (favorites_parks_id INT NOT NULL, park_id INT NOT NULL, INDEX IDX_56CB50E31D80C3C2 (favorites_parks_id), INDEX IDX_56CB50E344990C25 (park_id), PRIMARY KEY(favorites_parks_id, park_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoritesCoasters ADD CONSTRAINT FK_72C20C3FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorites_coasters_coaster ADD CONSTRAINT FK_BE36181B5073950D FOREIGN KEY (favorites_coasters_id) REFERENCES favoritesCoasters (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites_coasters_coaster ADD CONSTRAINT FK_BE36181B216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoritesParks ADD CONSTRAINT FK_A33D680DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorites_parks_park ADD CONSTRAINT FK_56CB50E31D80C3C2 FOREIGN KEY (favorites_parks_id) REFERENCES favoritesParks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites_parks_park ADD CONSTRAINT FK_56CB50E344990C25 FOREIGN KEY (park_id) REFERENCES parks (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoritesCoasters DROP FOREIGN KEY FK_72C20C3FA76ED395');
        $this->addSql('ALTER TABLE favorites_coasters_coaster DROP FOREIGN KEY FK_BE36181B5073950D');
        $this->addSql('ALTER TABLE favorites_coasters_coaster DROP FOREIGN KEY FK_BE36181B216303C');
        $this->addSql('ALTER TABLE favoritesParks DROP FOREIGN KEY FK_A33D680DA76ED395');
        $this->addSql('ALTER TABLE favorites_parks_park DROP FOREIGN KEY FK_56CB50E31D80C3C2');
        $this->addSql('ALTER TABLE favorites_parks_park DROP FOREIGN KEY FK_56CB50E344990C25');
        $this->addSql('DROP TABLE favoritesCoasters');
        $this->addSql('DROP TABLE favorites_coasters_coaster');
        $this->addSql('DROP TABLE favoritesParks');
        $this->addSql('DROP TABLE favorites_parks_park');
    }
}
