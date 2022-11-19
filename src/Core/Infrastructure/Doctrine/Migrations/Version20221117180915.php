<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221117180915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added owner column and created at in Device table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE devices ADD user_id UUID NOT NULL');
        $this->addSql('ALTER TABLE devices ADD created_at DATE NOT NULL');
        $this->addSql('COMMENT ON COLUMN devices.user_id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN devices.created_at IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE devices DROP user_id');
        $this->addSql('ALTER TABLE devices DROP created_at');
    }
}
