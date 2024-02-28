<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220154926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'picture table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `picture` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(45) NOT NULL,
                `pastry_id` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`pastry_id`)
                REFERENCES `pastry` (`id`)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `picture`');
    }
}
