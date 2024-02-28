<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220145907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'role table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `role` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(45) NOT NULL,
                `code` VARCHAR(45) NOT NULL,
                PRIMARY KEY (`id`)
            )
        ');


    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `role`');

    }
}
