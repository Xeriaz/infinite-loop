<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180521173425 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE milestone ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE milestone ADD CONSTRAINT FK_4FAC8382A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_4FAC8382A76ED395 ON milestone (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE milestone DROP FOREIGN KEY FK_4FAC8382A76ED395');
        $this->addSql('DROP INDEX IDX_4FAC8382A76ED395 ON milestone');
        $this->addSql('ALTER TABLE milestone DROP user_id');
    }
}
