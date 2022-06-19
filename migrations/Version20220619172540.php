<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220619172540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reaction CHANGE is_delete is_deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE is_delete is_deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE ticket_comment CHANGE is_delete is_deleted TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reaction CHANGE is_deleted is_delete TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE is_deleted is_delete TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE ticket_comment CHANGE is_deleted is_delete TINYINT(1) NOT NULL');
    }
}
