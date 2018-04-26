<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180426124505 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE challenges_groups ADD challenge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE challenges_groups ADD CONSTRAINT FK_4B17E66F98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
        $this->addSql('CREATE INDEX IDX_4B17E66F98A21AC6 ON challenges_groups (challenge_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE challenges_groups DROP FOREIGN KEY FK_4B17E66F98A21AC6');
        $this->addSql('DROP INDEX IDX_4B17E66F98A21AC6 ON challenges_groups');
        $this->addSql('ALTER TABLE challenges_groups DROP challenge_id');
    }
}
