<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220155500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'order_pastries table';
    }

    public function up(Schema $schema): void
    {$this->addSql('
            CREATE TABLE `order_pastries` (
                `quantity` INT NOT NULL,
                `pastry_id` INT NOT NULL,
                `order_id` INT NOT NULL,
                `format_id` INT NULL,
                PRIMARY KEY (`pastry_id`, `order_id`),
                FOREIGN KEY (`pastry_id`)
                REFERENCES `pastry` (`id`),
                FOREIGN KEY (`order_id`)
                REFERENCES `order` (`id`),
                FOREIGN KEY (`format_id`)
                REFERENCES `format` (`id`)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `order_pastries`');
    }
}
