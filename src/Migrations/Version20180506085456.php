<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180506085456 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE milestone (id INT AUTO_INCREMENT NOT NULL, challenge_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, completed_on DATETIME DEFAULT NULL, is_deleted TINYINT(1) NOT NULL, is_failed TINYINT(1) NOT NULL, INDEX IDX_4FAC838298A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_challenges (challenges_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A0D2610C95EE78BA (challenges_id), INDEX IDX_A0D2610CA76ED395 (user_id), PRIMARY KEY(challenges_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_groups (challenges_id INT NOT NULL, challenges_groups_id INT NOT NULL, INDEX IDX_3D09AB195EE78BA (challenges_id), INDEX IDX_3D09AB1AE3D98CB (challenges_groups_id), PRIMARY KEY(challenges_id, challenges_groups_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE milestone ADD CONSTRAINT FK_4FAC838298A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
        $this->addSql('ALTER TABLE user_challenges ADD CONSTRAINT FK_A0D2610C95EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_challenges ADD CONSTRAINT FK_A0D2610CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_groups ADD CONSTRAINT FK_3D09AB195EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_groups ADD CONSTRAINT FK_3D09AB1AE3D98CB FOREIGN KEY (challenges_groups_id) REFERENCES challenges_groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP challenges');
        $this->addSql('ALTER TABLE challenges ADD is_public TINYINT(1) NOT NULL, ADD is_completed TINYINT(1) NOT NULL, ADD completed_on DATETIME DEFAULT NULL, DROP user_challenges');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE milestone');
        $this->addSql('DROP TABLE user_challenges');
        $this->addSql('DROP TABLE challenge_groups');
        $this->addSql('ALTER TABLE challenges ADD user_challenges VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP is_public, DROP is_completed, DROP completed_on');
        $this->addSql('ALTER TABLE `user` ADD challenges VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
