<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180601125437 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE login_event CHANGE login_date login_date DATE NOT NULL, CHANGE login_time login_time TIME NOT NULL');
        $this->addSql('ALTER TABLE registration_event CHANGE registration_date registration_date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE login_event CHANGE login_date login_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE login_time login_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\'');
        $this->addSql('ALTER TABLE registration_event CHANGE registration_date registration_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
