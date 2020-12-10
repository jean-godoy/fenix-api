<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127125414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE generate_op (id INT AUTO_INCREMENT NOT NULL, op INT NOT NULL, fornecedor VARCHAR(255) NOT NULL, referencia VARCHAR(100) NOT NULL, cor INT NOT NULL, tipo VARCHAR(255) NOT NULL, semana INT NOT NULL, os INT NOT NULL, quantidade INT NOT NULL, preco_unitario NUMERIC(10, 2) NOT NULL, desc_service VARCHAR(100) NOT NULL, data_in DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE generate_op');
    }
}
