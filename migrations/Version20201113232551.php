<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113232551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, employee_name VARCHAR(100) NOT NULL, phone VARCHAR(12) NOT NULL, street VARCHAR(255) NOT NULL, cpf VARCHAR(11) NOT NULL, rg VARCHAR(15) NOT NULL, birth_date DATE NOT NULL, city VARCHAR(100) NOT NULL, uf VARCHAR(2) NOT NULL, email VARCHAR(100) NOT NULL, office VARCHAR(100) NOT NULL, salary NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE employees');
    }
}
