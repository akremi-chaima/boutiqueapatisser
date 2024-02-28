<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220145436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'collection table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `collection` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(100) NOT NULL,
                `is_active` TINYINT NOT NULL ,
                PRIMARY KEY (`id`)
            )
        ');


    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `collection`');

    }
}
