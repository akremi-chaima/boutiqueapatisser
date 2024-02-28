<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220155000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'format table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `format` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(100) NOT NULL,
                `pastry_id` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`pastry_id`)
                REFERENCES `pastry` (`id`)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `format`');
    }

}
