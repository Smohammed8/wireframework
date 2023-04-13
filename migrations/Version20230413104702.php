<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413104702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE woreda ADD agreement_id INT DEFAULT NULL, ADD is_agreed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE woreda ADD CONSTRAINT FK_889E2F724890B2B FOREIGN KEY (agreement_id) REFERENCES agreement (id)');
        $this->addSql('CREATE INDEX IDX_889E2F724890B2B ON woreda (agreement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE woreda DROP FOREIGN KEY FK_889E2F724890B2B');
        $this->addSql('DROP INDEX IDX_889E2F724890B2B ON woreda');
        $this->addSql('ALTER TABLE woreda DROP agreement_id, DROP is_agreed');
    }
}
