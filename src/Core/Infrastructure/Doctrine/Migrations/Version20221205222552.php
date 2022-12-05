<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221205222552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added CreatedAt column to User table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD created_at DATE NOT NULL');
        $this->addSql('COMMENT ON COLUMN users.created_at IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users DROP created_at');
    }
}
