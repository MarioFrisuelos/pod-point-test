<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613023838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, postcode VARCHAR(50) NOT NULL, name VARCHAR(255) NOT NULL, status ENUM(\'available\', \'charging\'), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge (id INT AUTO_INCREMENT NOT NULL, unit_id INT NOT NULL, start DATETIME NOT NULL, end DATETIME DEFAULT NULL, INDEX IDX_556BA434F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA434F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA434F8BD700D');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE charge');
    }
}
