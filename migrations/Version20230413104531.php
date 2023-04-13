<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413104531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE indigent ADD agreement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE indigent ADD CONSTRAINT FK_32B33E4C24890B2B FOREIGN KEY (agreement_id) REFERENCES agreement (id)');
        $this->addSql('CREATE INDEX IDX_32B33E4C24890B2B ON indigent (agreement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE indigent DROP FOREIGN KEY FK_32B33E4C24890B2B');
        $this->addSql('DROP INDEX IDX_32B33E4C24890B2B ON indigent');
        $this->addSql('ALTER TABLE indigent DROP agreement_id');
    }
}
