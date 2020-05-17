<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517213241 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel_review (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, service_rating SMALLINT NOT NULL, sleep_rating SMALLINT NOT NULL, location_rating SMALLINT NOT NULL, pool_rating SMALLINT NOT NULL, value_rating SMALLINT NOT NULL, cleanliness_rating SMALLINT NOT NULL, rooms_rating SMALLINT NOT NULL, fitness_rating SMALLINT NOT NULL, title LONGTEXT NOT NULL, description LONGTEXT NOT NULL, reviewer_name VARCHAR(255) NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_E5A953A13243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, subtitle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, max_guests SMALLINT NOT NULL, price INT NOT NULL, INDEX IDX_729F519B3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_occupation (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, book_date DATETIME NOT NULL, INDEX IDX_360A0D4D54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel_review ADD CONSTRAINT FK_E5A953A13243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE room_occupation ADD CONSTRAINT FK_360A0D4D54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE city CHANGE region_id region_id INT DEFAULT NULL, CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel CHANGE city_id city_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE hotel_facility CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partner CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE country_id country_id SMALLINT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room_occupation DROP FOREIGN KEY FK_360A0D4D54177093');
        $this->addSql('DROP TABLE hotel_review');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE room_occupation');
        $this->addSql('ALTER TABLE city CHANGE region_id region_id INT DEFAULT NULL, CHANGE country_id country_id SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel CHANGE city_id city_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE hotel_facility CHANGE hotel_id hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partner CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE country_id country_id SMALLINT DEFAULT NULL');
    }
}
