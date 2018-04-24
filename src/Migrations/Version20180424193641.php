<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180424193641 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE milestone (id INT AUTO_INCREMENT NOT NULL, challenge_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, completed_on DATETIME DEFAULT NULL, deleted TINYINT(1) NOT NULL, INDEX IDX_4FAC838298A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE milestone ADD CONSTRAINT FK_4FAC838298A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE milestone');
    }
}
