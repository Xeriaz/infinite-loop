<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180510083702 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_milestone_status (user_id INT NOT NULL, milestone_id INT NOT NULL, is_completed TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, is_failed TINYINT(1) NOT NULL, submitted_on DATETIME DEFAULT NULL, INDEX IDX_E2B6713A76ED395 (user_id), INDEX IDX_E2B67134B3E2EDA (milestone_id), PRIMARY KEY(user_id, milestone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenges (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_public TINYINT(1) NOT NULL, is_completed TINYINT(1) NOT NULL, completed_on DATETIME DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_milestone_status ADD CONSTRAINT FK_E2B6713A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_milestone_status ADD CONSTRAINT FK_E2B67134B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id)');
        $this->addSql('ALTER TABLE milestone DROP status, DROP completed_on, DROP is_deleted, DROP is_failed');
        $this->addSql('ALTER TABLE milestone ADD CONSTRAINT FK_4FAC838298A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
        $this->addSql('ALTER TABLE user_challenges ADD CONSTRAINT FK_A0D2610C95EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_challenges ADD CONSTRAINT FK_A0D2610CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_groups ADD CONSTRAINT FK_3D09AB195EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_groups ADD CONSTRAINT FK_3D09AB1AE3D98CB FOREIGN KEY (challenges_groups_id) REFERENCES challenges_groups (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE milestone DROP FOREIGN KEY FK_4FAC838298A21AC6');
        $this->addSql('ALTER TABLE user_challenges DROP FOREIGN KEY FK_A0D2610C95EE78BA');
        $this->addSql('ALTER TABLE challenge_groups DROP FOREIGN KEY FK_3D09AB195EE78BA');
        $this->addSql('DROP TABLE user_milestone_status');
        $this->addSql('DROP TABLE challenges');
        $this->addSql('ALTER TABLE challenge_groups DROP FOREIGN KEY FK_3D09AB1AE3D98CB');
        $this->addSql('ALTER TABLE milestone ADD status TINYINT(1) NOT NULL, ADD completed_on DATETIME DEFAULT NULL, ADD is_deleted TINYINT(1) NOT NULL, ADD is_failed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_challenges DROP FOREIGN KEY FK_A0D2610CA76ED395');
    }
}
