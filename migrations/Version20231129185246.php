<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129185246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, name VARCHAR(255) NOT NULL, balance NUMERIC(17, 2) NOT NULL, currency VARCHAR(3) NOT NULL, INDEX IDX_7D3656A419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, account_from_id INT NOT NULL, account_to_id INT NOT NULL, amount NUMERIC(17, 2) NOT NULL, currency VARCHAR(3) NOT NULL, date DATETIME NOT NULL, INDEX IDX_EAA81A4CB1E5CD43 (account_from_id), INDEX IDX_EAA81A4C6BA9314 (account_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CB1E5CD43 FOREIGN KEY (account_from_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C6BA9314 FOREIGN KEY (account_to_id) REFERENCES account (id)');
        $this->setUpDefaultClients();
        $this->setUpDefaultAccounts();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A419EB6921');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CB1E5CD43');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C6BA9314');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE transactions');
    }

    private function setUpDefaultAccounts(): void
    {
        $this->addSql(
            "INSERT INTO `account` (`id`, `client_id`, `name`, `balance`, `currency`) VALUES
            (1, 1, 'Līva Account 1', 100.00, 'EUR'),
            (2, 1, 'Līva Account 2', 0.00, 'GBP'),
            (3, 2, 'Aivars Account', 145.59, 'EUR'),
            (4, 3, 'Elīza Account', 130.00, 'EUR'),
            (5, 4, 'Anete Account', 100500.30, 'EUR'),
            (6, 5, 'Daniel Account 1', 0.30, 'USD'),
            (7, 5, 'Daniel Account 2', 503.00, 'SEK'),
            (8, 6, 'Aleksandr Account', 879.00, 'USD'),
            (9, 7, 'Eleanore Account 1', 900023.00, 'USD'),
            (10, 7, 'Eleanore Account 2', 1.05, 'USD'),
            (11, 7, 'Eleanore Account 3', 4234.00, 'GBP'),
            (12, 8, 'George Account', 34523.32, 'EUR');"
        );
    }

    private function setUpDefaultClients(): void
    {
        $this->addSql(
            "INSERT INTO `client` (`id`, `name`, `surname`) VALUES
                (1, 'Līva', 'Bērziņa'),
                (2, 'Aivars', 'Krūmiņš'),
                (3, 'Elīza', 'Laimīte'),
                (4, 'Anete', 'Streika'),
                (5, 'Daniel', 'Gorg'),
                (6, 'Aleksandr', 'Nerkovich'),
                (7, 'Eleanore', 'Ghool'),
                (8, 'George', 'Bosh'),
                (9, 'Jānis', 'Karals');"
        );
    }

}
