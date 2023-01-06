<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221210113929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added devices_features and features tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE devices_features (id UUID NOT NULL, feature_id UUID NOT NULL, device_id UUID NOT NULL, payload JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN devices_features.id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN devices_features.feature_id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN devices_features.device_id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('CREATE TABLE features (feature_id UUID NOT NULL, name VARCHAR(255) NOT NULL, code_name VARCHAR(255) NOT NULL, display_type VARCHAR(255) NOT NULL, PRIMARY KEY(feature_id))');
        $this->addSql('COMMENT ON COLUMN features.feature_id IS \'(DC2Type:uuid_type)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE devices_features');
        $this->addSql('DROP TABLE features');
    }
}
