<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220154407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'order table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `order` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `created_at` datetime NOT NULL,
                `user_id` INT NOT NULL,
                `order_status_id` INT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`user_id`)
                REFERENCES `user` (`id`),
                FOREIGN KEY (`order_status_id`)
                REFERENCES `order_status` (`id`)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `order`');
    }
}
