<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829125620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atdevice (id INT AUTO_INCREMENT NOT NULL, at_device_type_id INT NOT NULL, at_platform_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D9A99C5972AB9908 (at_device_type_id), INDEX IDX_D9A99C5960AA3C74 (at_platform_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atdevice_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atplatform (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_disability (client_id INT NOT NULL, disability_id INT NOT NULL, INDEX IDX_D16E61F319EB6921 (client_id), INDEX IDX_D16E61F3709924E5 (disability_id), PRIMARY KEY(client_id, disability_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disability (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atdevice ADD CONSTRAINT FK_D9A99C5972AB9908 FOREIGN KEY (at_device_type_id) REFERENCES atdevice_type (id)');
        $this->addSql('ALTER TABLE atdevice ADD CONSTRAINT FK_D9A99C5960AA3C74 FOREIGN KEY (at_platform_id) REFERENCES atplatform (id)');
        $this->addSql('ALTER TABLE client_disability ADD CONSTRAINT FK_D16E61F319EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_disability ADD CONSTRAINT FK_D16E61F3709924E5 FOREIGN KEY (disability_id) REFERENCES disability (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atdevice DROP FOREIGN KEY FK_D9A99C5972AB9908');
        $this->addSql('ALTER TABLE atdevice DROP FOREIGN KEY FK_D9A99C5960AA3C74');
        $this->addSql('ALTER TABLE client_disability DROP FOREIGN KEY FK_D16E61F319EB6921');
        $this->addSql('ALTER TABLE client_disability DROP FOREIGN KEY FK_D16E61F3709924E5');
        $this->addSql('DROP TABLE atdevice');
        $this->addSql('DROP TABLE atdevice_type');
        $this->addSql('DROP TABLE atplatform');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_disability');
        $this->addSql('DROP TABLE disability');
    }
}
