<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119151638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coaster_manufacturer DROP FOREIGN KEY FK_81167007216303C');
        $this->addSql('ALTER TABLE coaster_manufacturer DROP FOREIGN KEY FK_81167007A23B42D');
        $this->addSql('ALTER TABLE coaster_material_type DROP FOREIGN KEY FK_C90B2DD6216303C');
        $this->addSql('ALTER TABLE coaster_material_type DROP FOREIGN KEY FK_C90B2DD674D6573C');
        $this->addSql('ALTER TABLE coaster_park DROP FOREIGN KEY FK_F84020E044990C25');
        $this->addSql('ALTER TABLE coaster_park DROP FOREIGN KEY FK_F84020E0216303C');
        $this->addSql('ALTER TABLE coaster_model DROP FOREIGN KEY FK_C873B6EA216303C');
        $this->addSql('ALTER TABLE coaster_model DROP FOREIGN KEY FK_C873B6EA7975B7E7');
        $this->addSql('ALTER TABLE coaster_restraint DROP FOREIGN KEY FK_F7E8C465950622D7');
        $this->addSql('ALTER TABLE coaster_restraint DROP FOREIGN KEY FK_F7E8C465216303C');
        $this->addSql('ALTER TABLE coaster_seating_type DROP FOREIGN KEY FK_30F1A7B8216303C');
        $this->addSql('ALTER TABLE coaster_seating_type DROP FOREIGN KEY FK_30F1A7B8343629B2');
        $this->addSql('ALTER TABLE coaster_status DROP FOREIGN KEY FK_C4CFE2CE216303C');
        $this->addSql('ALTER TABLE coaster_status DROP FOREIGN KEY FK_C4CFE2CE6BF700BD');
        $this->addSql('DROP TABLE coaster_manufacturer');
        $this->addSql('DROP TABLE coaster_material_type');
        $this->addSql('DROP TABLE coaster_park');
        $this->addSql('DROP TABLE coaster_model');
        $this->addSql('DROP TABLE coaster_restraint');
        $this->addSql('DROP TABLE coaster_seating_type');
        $this->addSql('DROP TABLE coaster_status');
        $this->addSql('ALTER TABLE coasters ADD material_type_id INT NOT NULL, ADD seating_type_id INT NOT NULL, ADD model_id INT NOT NULL, ADD manufacturer_id INT NOT NULL, ADD restraint_id INT NOT NULL, ADD park_id INT NOT NULL, ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F74D6573C FOREIGN KEY (material_type_id) REFERENCES materialType (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F343629B2 FOREIGN KEY (seating_type_id) REFERENCES seatingType (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072FA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F950622D7 FOREIGN KEY (restraint_id) REFERENCES restraint (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F44990C25 FOREIGN KEY (park_id) REFERENCES parks (id)');
        $this->addSql('ALTER TABLE coasters ADD CONSTRAINT FK_4526072F6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_4526072F74D6573C ON coasters (material_type_id)');
        $this->addSql('CREATE INDEX IDX_4526072F343629B2 ON coasters (seating_type_id)');
        $this->addSql('CREATE INDEX IDX_4526072F7975B7E7 ON coasters (model_id)');
        $this->addSql('CREATE INDEX IDX_4526072FA23B42D ON coasters (manufacturer_id)');
        $this->addSql('CREATE INDEX IDX_4526072F950622D7 ON coasters (restraint_id)');
        $this->addSql('CREATE INDEX IDX_4526072F44990C25 ON coasters (park_id)');
        $this->addSql('CREATE INDEX IDX_4526072F6BF700BD ON coasters (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coaster_manufacturer (coaster_id INT NOT NULL, manufacturer_id INT NOT NULL, INDEX IDX_81167007A23B42D (manufacturer_id), INDEX IDX_81167007216303C (coaster_id), PRIMARY KEY(coaster_id, manufacturer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE coaster_material_type (coaster_id INT NOT NULL, material_type_id INT NOT NULL, INDEX IDX_C90B2DD6216303C (coaster_id), INDEX IDX_C90B2DD674D6573C (material_type_id), PRIMARY KEY(coaster_id, material_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE coaster_park (coaster_id INT NOT NULL, park_id INT NOT NULL, INDEX IDX_F84020E044990C25 (park_id), INDEX IDX_F84020E0216303C (coaster_id), PRIMARY KEY(coaster_id, park_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE coaster_model (coaster_id INT NOT NULL, model_id INT NOT NULL, INDEX IDX_C873B6EA216303C (coaster_id), INDEX IDX_C873B6EA7975B7E7 (model_id), PRIMARY KEY(coaster_id, model_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE coaster_restraint (coaster_id INT NOT NULL, restraint_id INT NOT NULL, INDEX IDX_F7E8C465950622D7 (restraint_id), INDEX IDX_F7E8C465216303C (coaster_id), PRIMARY KEY(coaster_id, restraint_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE coaster_seating_type (coaster_id INT NOT NULL, seating_type_id INT NOT NULL, INDEX IDX_30F1A7B8216303C (coaster_id), INDEX IDX_30F1A7B8343629B2 (seating_type_id), PRIMARY KEY(coaster_id, seating_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE coaster_status (coaster_id INT NOT NULL, status_id INT NOT NULL, INDEX IDX_C4CFE2CE216303C (coaster_id), INDEX IDX_C4CFE2CE6BF700BD (status_id), PRIMARY KEY(coaster_id, status_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE coaster_manufacturer ADD CONSTRAINT FK_81167007216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id)');
        $this->addSql('ALTER TABLE coaster_manufacturer ADD CONSTRAINT FK_81167007A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_material_type ADD CONSTRAINT FK_C90B2DD6216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id)');
        $this->addSql('ALTER TABLE coaster_material_type ADD CONSTRAINT FK_C90B2DD674D6573C FOREIGN KEY (material_type_id) REFERENCES materialType (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_park ADD CONSTRAINT FK_F84020E044990C25 FOREIGN KEY (park_id) REFERENCES parks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_park ADD CONSTRAINT FK_F84020E0216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id)');
        $this->addSql('ALTER TABLE coaster_model ADD CONSTRAINT FK_C873B6EA216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id)');
        $this->addSql('ALTER TABLE coaster_model ADD CONSTRAINT FK_C873B6EA7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_restraint ADD CONSTRAINT FK_F7E8C465950622D7 FOREIGN KEY (restraint_id) REFERENCES restraint (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_restraint ADD CONSTRAINT FK_F7E8C465216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id)');
        $this->addSql('ALTER TABLE coaster_seating_type ADD CONSTRAINT FK_30F1A7B8216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id)');
        $this->addSql('ALTER TABLE coaster_seating_type ADD CONSTRAINT FK_30F1A7B8343629B2 FOREIGN KEY (seating_type_id) REFERENCES seatingType (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_status ADD CONSTRAINT FK_C4CFE2CE216303C FOREIGN KEY (coaster_id) REFERENCES coasters (id)');
        $this->addSql('ALTER TABLE coaster_status ADD CONSTRAINT FK_C4CFE2CE6BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F74D6573C');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F343629B2');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F7975B7E7');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072FA23B42D');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F950622D7');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F44990C25');
        $this->addSql('ALTER TABLE coasters DROP FOREIGN KEY FK_4526072F6BF700BD');
        $this->addSql('DROP INDEX IDX_4526072F74D6573C ON coasters');
        $this->addSql('DROP INDEX IDX_4526072F343629B2 ON coasters');
        $this->addSql('DROP INDEX IDX_4526072F7975B7E7 ON coasters');
        $this->addSql('DROP INDEX IDX_4526072FA23B42D ON coasters');
        $this->addSql('DROP INDEX IDX_4526072F950622D7 ON coasters');
        $this->addSql('DROP INDEX IDX_4526072F44990C25 ON coasters');
        $this->addSql('DROP INDEX IDX_4526072F6BF700BD ON coasters');
        $this->addSql('ALTER TABLE coasters DROP material_type_id, DROP seating_type_id, DROP model_id, DROP manufacturer_id, DROP restraint_id, DROP park_id, DROP status_id');
    }
}
