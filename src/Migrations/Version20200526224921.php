<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526224921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city CHANGE region_id region_id INT DEFAULT NULL, CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_message CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE hotel CHANGE city_id city_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE hotel_facility CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_photo CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_review CHANGE hotel_id hotel_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE news CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE partner CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_occupation CHANGE room_id room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(180) NOT NULL, ADD last_name VARCHAR(180) NOT NULL, ADD picture_url VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE facebook_id facebook_id VARCHAR(180) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city CHANGE region_id region_id INT DEFAULT NULL, CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_message CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE hotel CHANGE city_id city_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE hotel_facility CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_photo CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_review CHANGE hotel_id hotel_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE news CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE partner CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_occupation CHANGE room_id room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP picture_url, CHANGE facebook_id facebook_id VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
