<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221117181143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Removed devices column from Users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP devices');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD devices JSON NOT NULL');
    }
}
