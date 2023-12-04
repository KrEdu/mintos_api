<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204005945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            "INSERT INTO `transactions` (`id`, `account_from_id`, `account_to_id`, `amount`, `currency`, `date`, `status`) VALUES
                    (1, 5, 7, 500.00, 'SEK', '2023-12-04 00:35:37', 'finished'),
                    (2, 5, 7, 500.00, 'SEK', '2023-12-04 00:35:39', 'finished'),
                    (3, 7, 5, 5.04, 'EUR', '2023-12-04 00:36:00', 'finished'),
                    (4, 7, 5, 5.04, 'EUR', '2023-12-04 00:36:01', 'finished'),
                    (5, 1, 3, 5.04, 'EUR', '2023-12-04 00:38:03', 'finished'),
                    (6, 1, 3, 5.04, 'EUR', '2023-12-04 00:38:33', 'finished'),
                    (7, 9, 2, 155.00, 'GBP', '2023-12-04 00:39:35', 'finished');"
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
