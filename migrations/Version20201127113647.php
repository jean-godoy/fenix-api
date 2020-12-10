<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127113647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE generate_op ADD fornecedor VARCHAR(255) NOT NULL, ADD data_in DATETIME NOT NULL, ADD referencia VARCHAR(100) NOT NULL, ADD cor INT NOT NULL, ADD tipo VARCHAR(255) NOT NULL, ADD semana INT NOT NULL, ADD os INT NOT NULL, ADD quantidade INT NOT NULL, ADD preco_unitario NUMERIC(10, 2) NOT NULL, ADD desc_service VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE generate_op DROP fornecedor, DROP data_in, DROP referencia, DROP cor, DROP tipo, DROP semana, DROP os, DROP quantidade, DROP preco_unitario, DROP desc_service');
    }
}
