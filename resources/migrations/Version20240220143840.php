<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220143840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'category table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `category` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(60) NOT NULL,
                `is_active` TINYINT NOT NULL ,
                PRIMARY KEY (`id`)
            )
        ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `category`');

    }
}
