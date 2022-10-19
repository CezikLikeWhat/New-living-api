<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221019190130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changed Email column to EmailType';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(320)');
        $this->addSql('COMMENT ON COLUMN users.email IS \'(DC2Type:email_type)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(255)');
        $this->addSql('COMMENT ON COLUMN users.email IS NULL');
    }
}
