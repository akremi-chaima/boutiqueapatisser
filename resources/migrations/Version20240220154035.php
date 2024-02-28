<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220154035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'order_status table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `order_status` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(45) NOT NULL,
                PRIMARY KEY (`id`)
            )
        ');


    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `order_status`');

    }
}
