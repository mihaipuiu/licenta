<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518122011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel_photo (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, photo_filename VARCHAR(50) NOT NULL, INDEX IDX_F7634ADC3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel_photo ADD CONSTRAINT FK_F7634ADC3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE hotel CHANGE city_id city_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE city CHANGE region_id region_id INT DEFAULT NULL, CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_facility CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_review CHANGE hotel_id hotel_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE news CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE partner CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_occupation CHANGE room_id room_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE hotel_photo');
        $this->addSql('ALTER TABLE city CHANGE region_id region_id INT DEFAULT NULL, CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel CHANGE city_id city_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE hotel_facility CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_review CHANGE hotel_id hotel_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE news CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE partner CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_occupation CHANGE room_id room_id INT DEFAULT NULL');
    }
}
