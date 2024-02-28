<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220152924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'address table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `address` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `city` VARCHAR(45) NOT NULL,
                `zip_code` VARCHAR(5) NOT NULL,
                `street` VARCHAR(100) NOT NULL,
                `user_id` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`user_id`)
                REFERENCES `user` (`id`)
            )
        ');


    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `address`');

    }
}
