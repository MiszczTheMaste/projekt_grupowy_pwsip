<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125222030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        
        $this->addSql('CREATE TABLE categories (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_polish_ci`, visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE opinions (id INT UNSIGNED AUTO_INCREMENT NOT NULL, product_id INT UNSIGNED NOT NULL, rating TINYINT(1) NOT NULL, INDEX product_id (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE products (id INT UNSIGNED AUTO_INCREMENT NOT NULL, category_id INT UNSIGNED NOT NULL, name VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_polish_ci`, price NUMERIC(7, 2) UNSIGNED NOT NULL, INDEX category_id (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stock (id INT UNSIGNED AUTO_INCREMENT NOT NULL, product_id INT UNSIGNED NOT NULL, amount INT UNSIGNED NOT NULL, amount_left INT UNSIGNED NOT NULL, INDEX amount_left (amount_left), INDEX product_id (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE opinions ADD CONSTRAINT opinions_product_fk FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT product_category_fk FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT product_fk FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'); 
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY product_category_fk');
        $this->addSql('ALTER TABLE opinions DROP FOREIGN KEY opinions_product_fk');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY product_fk');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE opinions');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
    }
}
