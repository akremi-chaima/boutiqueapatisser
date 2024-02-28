<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220151333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'pastry table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `pastry` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(60) NOT NULL,
                `picture` VARCHAR(100) NULL,
                `price` DECIMAL(10,2) NOT NULL,
                `description` longtext NOT NULL,
                `is_visible` TINYINT NOT NULL ,
                `category_id` INT NOT NULL,
                `sub_collection_id` INT NOT NULL,
                `flavour_id` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`category_id`)
                REFERENCES `category` (`id`),
                FOREIGN KEY (`sub_collection_id`)
                REFERENCES `sub_collection` (`id`),
                FOREIGN KEY (`flavour_id`)
                REFERENCES `flavour` (`id`)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `pastry`');
    }
}
