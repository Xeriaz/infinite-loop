<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180514110617 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_milestone_status (user_id INT NOT NULL, milestone_id INT NOT NULL, is_completed TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, is_failed TINYINT(1) NOT NULL, submitted_on DATETIME DEFAULT NULL, INDEX IDX_E2B6713A76ED395 (user_id), INDEX IDX_E2B67134B3E2EDA (milestone_id), PRIMARY KEY(user_id, milestone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE milestone (id INT AUTO_INCREMENT NOT NULL, challenge_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_4FAC838298A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, challenge_id INT NOT NULL, posted_on DATETIME NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C98A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenges (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_public TINYINT(1) NOT NULL, is_completed TINYINT(1) NOT NULL, add_proof TINYINT(1) NOT NULL, completed_on DATETIME DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_7B5A7E0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_challenges (challenges_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A0D2610C95EE78BA (challenges_id), INDEX IDX_A0D2610CA76ED395 (user_id), PRIMARY KEY(challenges_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_groups (challenges_id INT NOT NULL, challenges_groups_id INT NOT NULL, INDEX IDX_3D09AB195EE78BA (challenges_id), INDEX IDX_3D09AB1AE3D98CB (challenges_groups_id), PRIMARY KEY(challenges_id, challenges_groups_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, challenge_id INT DEFAULT NULL, created_on DATETIME NOT NULL, is_read TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, read_on DATETIME DEFAULT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), INDEX IDX_BF5476CA98A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_milestone_status ADD CONSTRAINT FK_E2B6713A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_milestone_status ADD CONSTRAINT FK_E2B67134B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id)');
        $this->addSql('ALTER TABLE milestone ADD CONSTRAINT FK_4FAC838298A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
        $this->addSql('ALTER TABLE challenges ADD CONSTRAINT FK_7B5A7E0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_challenges ADD CONSTRAINT FK_A0D2610C95EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_challenges ADD CONSTRAINT FK_A0D2610CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_groups ADD CONSTRAINT FK_3D09AB195EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_groups ADD CONSTRAINT FK_3D09AB1AE3D98CB FOREIGN KEY (challenges_groups_id) REFERENCES challenges_groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_milestone_status DROP FOREIGN KEY FK_E2B67134B3E2EDA');
        $this->addSql('ALTER TABLE milestone DROP FOREIGN KEY FK_4FAC838298A21AC6');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C98A21AC6');
        $this->addSql('ALTER TABLE user_challenges DROP FOREIGN KEY FK_A0D2610C95EE78BA');
        $this->addSql('ALTER TABLE challenge_groups DROP FOREIGN KEY FK_3D09AB195EE78BA');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA98A21AC6');
        $this->addSql('ALTER TABLE user_milestone_status DROP FOREIGN KEY FK_E2B6713A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE challenges DROP FOREIGN KEY FK_7B5A7E0A76ED395');
        $this->addSql('ALTER TABLE user_challenges DROP FOREIGN KEY FK_A0D2610CA76ED395');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('DROP TABLE user_milestone_status');
        $this->addSql('DROP TABLE milestone');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE challenges');
        $this->addSql('DROP TABLE user_challenges');
        $this->addSql('DROP TABLE challenge_groups');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE notification');
    }
}
