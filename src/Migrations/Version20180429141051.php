<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180429141051 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE challenges_challenges_groups (challenges_id INT NOT NULL, challenges_groups_id INT NOT NULL, INDEX IDX_3612811C95EE78BA (challenges_id), INDEX IDX_3612811CAE3D98CB (challenges_groups_id), PRIMARY KEY(challenges_id, challenges_groups_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenges_challenges_groups ADD CONSTRAINT FK_3612811C95EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenges_challenges_groups ADD CONSTRAINT FK_3612811CAE3D98CB FOREIGN KEY (challenges_groups_id) REFERENCES challenges_groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenges_groups DROP FOREIGN KEY FK_4B17E66F98A21AC6');
        $this->addSql('DROP INDEX IDX_4B17E66F98A21AC6 ON challenges_groups');
        $this->addSql('ALTER TABLE challenges_groups DROP challenge_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE challenges_challenges_groups');
        $this->addSql('ALTER TABLE challenges_groups ADD challenge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE challenges_groups ADD CONSTRAINT FK_4B17E66F98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
        $this->addSql('CREATE INDEX IDX_4B17E66F98A21AC6 ON challenges_groups (challenge_id)');
    }
}
