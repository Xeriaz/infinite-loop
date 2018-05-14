<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180514052730 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, challenge_id INT DEFAULT NULL, created_on DATETIME NOT NULL, is_read TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, read_on DATETIME DEFAULT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), INDEX IDX_BF5476CA98A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
        $this->addSql('ALTER TABLE milestone DROP status, DROP completed_on, DROP is_deleted, DROP is_failed');
        $this->addSql('ALTER TABLE challenges ADD user_id INT DEFAULT NULL, ADD add_proof TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE challenges ADD CONSTRAINT FK_7B5A7E0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_7B5A7E0A76ED395 ON challenges (user_id)');
        $this->addSql('ALTER TABLE user_milestone_status ADD CONSTRAINT FK_E2B6713A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_milestone_status ADD CONSTRAINT FK_E2B67134B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE notification');
        $this->addSql('ALTER TABLE challenges DROP FOREIGN KEY FK_7B5A7E0A76ED395');
        $this->addSql('DROP INDEX IDX_7B5A7E0A76ED395 ON challenges');
        $this->addSql('ALTER TABLE challenges DROP user_id, DROP add_proof');
        $this->addSql('ALTER TABLE milestone ADD status TINYINT(1) NOT NULL, ADD completed_on DATETIME DEFAULT NULL, ADD is_deleted TINYINT(1) NOT NULL, ADD is_failed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_milestone_status DROP FOREIGN KEY FK_E2B6713A76ED395');
        $this->addSql('ALTER TABLE user_milestone_status DROP FOREIGN KEY FK_E2B67134B3E2EDA');
    }
}
