<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220150746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'sub_collection table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `sub_collection` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(60) NOT NULL,
                `collection_id` INT NOT NULL,
                `is_active` TINYINT NOT NULL ,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`collection_id`)
                REFERENCES `collection` (`id`)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `sub_collection`');
    }

}
