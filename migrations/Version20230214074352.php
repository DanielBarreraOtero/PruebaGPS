<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214074352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banda (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, distancia INT NOT NULL, rango_min INT NOT NULL, rango_max INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mensaje (id INT AUTO_INCREMENT NOT NULL, banda_id INT NOT NULL, modo_id INT NOT NULL, participante_id INT NOT NULL, hora DATETIME NOT NULL, validado TINYINT(1) NOT NULL, INDEX IDX_9B631D019EFB0C1D (banda_id), INDEX IDX_9B631D011858652E (modo_id), INDEX IDX_9B631D01F6F50196 (participante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participante (id INT AUTO_INCREMENT NOT NULL, indicativo VARCHAR(6) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido1 VARCHAR(255) NOT NULL, apellido2 VARCHAR(255) DEFAULT NULL, imagen LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_85BDC5C33D57FC59 (indicativo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mensaje ADD CONSTRAINT FK_9B631D019EFB0C1D FOREIGN KEY (banda_id) REFERENCES banda (id)');
        $this->addSql('ALTER TABLE mensaje ADD CONSTRAINT FK_9B631D011858652E FOREIGN KEY (modo_id) REFERENCES modo (id)');
        $this->addSql('ALTER TABLE mensaje ADD CONSTRAINT FK_9B631D01F6F50196 FOREIGN KEY (participante_id) REFERENCES participante (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mensaje DROP FOREIGN KEY FK_9B631D019EFB0C1D');
        $this->addSql('ALTER TABLE mensaje DROP FOREIGN KEY FK_9B631D011858652E');
        $this->addSql('ALTER TABLE mensaje DROP FOREIGN KEY FK_9B631D01F6F50196');
        $this->addSql('DROP TABLE banda');
        $this->addSql('DROP TABLE mensaje');
        $this->addSql('DROP TABLE modo');
        $this->addSql('DROP TABLE participante');
    }
}
