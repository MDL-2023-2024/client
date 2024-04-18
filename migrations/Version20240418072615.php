<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418072615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status_inscription (id VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription ADD status_id VARCHAR(255) DEFAULT \'EP\' NOT NULL, ADD email_confirmation VARCHAR(255) NOT NULL, ADD date_modification DATE NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D66BF700BD FOREIGN KEY (status_id) REFERENCES status_inscription (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D66BF700BD ON inscription (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D66BF700BD');
        $this->addSql('DROP TABLE status_inscription');
        $this->addSql('DROP INDEX IDX_5E90F6D66BF700BD ON inscription');
        $this->addSql('ALTER TABLE inscription DROP status_id, DROP email_confirmation, DROP date_modification');
    }
}
