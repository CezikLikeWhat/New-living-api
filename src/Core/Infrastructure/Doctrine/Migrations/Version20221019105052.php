<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221019105052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added Devices table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE devices (id UUID NOT NULL, name VARCHAR(255) NOT NULL, device_type VARCHAR(255) NOT NULL, mac_address VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN devices.id IS \'(DC2Type:uuid_type)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE devices');
    }
}
