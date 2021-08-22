<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820150726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Table for conversions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table currency_conversion
            (
                "source" char(3) not null,
                "target" char(3) not null,
                rate decimal not null,
                constraint currency_conversion_pk
                    primary key ("source", "target")
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE currency_conversion');
    }
}
