<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180530121957 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX name ON city');
        $this->addSql('ALTER TABLE country RENAME INDEX name TO UNIQ_5373C9665E237E06');
        $this->addSql('ALTER TABLE user DROP INDEX username, ADD UNIQUE INDEX UNIQ_8D93D649F85E0677 (username)');
        $this->addSql('ALTER TABLE user DROP INDEX email, ADD UNIQUE INDEX UNIQ_8D93D649E7927C74 (email)');
        $this->addSql('DROP INDEX username_2 ON user');
        $this->addSql('DROP INDEX email_2 ON user');
        $this->addSql('ALTER TABLE user ADD date_of_birth DATE NOT NULL, CHANGE username username VARCHAR(25) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX name ON city (name)');
        $this->addSql('ALTER TABLE country RENAME INDEX uniq_5373c9665e237e06 TO name');
        $this->addSql('ALTER TABLE user DROP date_of_birth, CHANGE username username VARCHAR(254) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX username_2 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX email_2 ON user (email)');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649f85e0677 TO username');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649e7927c74 TO email');
    }
}
