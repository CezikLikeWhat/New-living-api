<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221018175906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added Users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, google_id VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, devices JSON NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:uuid_type)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
