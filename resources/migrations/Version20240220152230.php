<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220152230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `user` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `first_name` VARCHAR(45) NOT NULL,
                `last_name` VARCHAR(45) NOT NULL,
                `phone_number` VARCHAR(10) NOT NULL,
                `password` VARCHAR(200) NOT NULL,
                `email` VARCHAR(100) NOT NULL,
                `role_id` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`role_id`)
                REFERENCES `role` (`id`)
            )
        ');


    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `user`');

    }
}
